package sv.ues.aa13032.medcontrol.ui

import android.os.Bundle
import android.widget.Toast
import androidx.appcompat.app.AppCompatActivity
import com.google.android.material.button.MaterialButton
import com.google.android.material.textfield.TextInputEditText
import retrofit2.Call
import retrofit2.Callback
import retrofit2.Response
import sv.ues.aa13032.medcontrol.R
import sv.ues.aa13032.medcontrol.datos.modelos.Hospital
import sv.ues.aa13032.medcontrol.datos.modelos.RespuestaApi
import sv.ues.aa13032.medcontrol.datos.repositorios.RepositorioHospital
import sv.ues.aa13032.medcontrol.utilidades.ValidadorCampos

class RegistroHospitalActivity : AppCompatActivity() {
    private val repositorioHospital = RepositorioHospital()

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_registro_hospital)

        findViewById<MaterialButton>(R.id.btnGuardarHospital).setOnClickListener {
            registrarHospital()
        }
    }

    private fun registrarHospital() {
        val nombre = valor(R.id.txtNomHospital)
        val capacidad = valor(R.id.txtCapacidadAtencion)
        val especialidades = valor(R.id.txtEspecialidades)

        if (listOf(nombre, capacidad, especialidades).any { ValidadorCampos.estaVacio(it) }) {
            mostrar("Complete todos los datos del hospital.")
            return
        }

        val hospital = Hospital("", nombre, capacidad, especialidades)

        repositorioHospital.registrar(hospital).enqueue(object : Callback<RespuestaApi<Hospital>> {
            override fun onResponse(call: Call<RespuestaApi<Hospital>>, response: Response<RespuestaApi<Hospital>>) {
                val hospitalRegistrado = response.body()?.data
                val mensaje = if (response.isSuccessful && hospitalRegistrado != null) {
                    "${response.body()?.message} Codigo: ${hospitalRegistrado.IdHospital}"
                } else {
                    response.body()?.message ?: "No se pudo registrar el hospital."
                }
                mostrar(mensaje)
                if (response.isSuccessful) limpiarCampos()
            }

            override fun onFailure(call: Call<RespuestaApi<Hospital>>, t: Throwable) {
                mostrar("No fue posible conectar con la API local.")
            }
        })
    }

    private fun valor(id: Int): String = findViewById<TextInputEditText>(id).text?.toString().orEmpty()

    private fun limpiarCampos() {
        listOf(R.id.txtNomHospital, R.id.txtCapacidadAtencion, R.id.txtEspecialidades)
            .forEach { findViewById<TextInputEditText>(it).setText("") }
    }

    private fun mostrar(mensaje: String) {
        Toast.makeText(this, mensaje, Toast.LENGTH_LONG).show()
    }
}

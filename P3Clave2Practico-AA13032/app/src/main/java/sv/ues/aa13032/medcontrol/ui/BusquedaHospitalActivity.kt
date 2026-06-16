package sv.ues.aa13032.medcontrol.ui

import android.os.Bundle
import android.view.View
import android.widget.LinearLayout
import android.widget.TextView
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

class BusquedaHospitalActivity : AppCompatActivity() {
    private val repositorioHospital = RepositorioHospital()

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_busqueda_hospital)

        findViewById<MaterialButton>(R.id.btnBuscarHospital).setOnClickListener {
            buscarHospital()
        }
    }

    private fun buscarHospital() {
        val idHospital = findViewById<TextInputEditText>(R.id.txtBuscarIdHospital).text?.toString().orEmpty()

        if (ValidadorCampos.estaVacio(idHospital)) {
            mostrar("Ingrese el codigo o nombre del hospital.")
            return
        }

        repositorioHospital.buscarPorId(idHospital).enqueue(object : Callback<RespuestaApi<Hospital>> {
            override fun onResponse(call: Call<RespuestaApi<Hospital>>, response: Response<RespuestaApi<Hospital>>) {
                val hospital = response.body()?.data
                if (response.isSuccessful && hospital != null) {
                    mostrarHospital(hospital)
                } else {
                    ocultarResultado()
                    mostrar(response.body()?.message ?: "Hospital no encontrado en MedControl.")
                }
            }

            override fun onFailure(call: Call<RespuestaApi<Hospital>>, t: Throwable) {
                ocultarResultado()
                mostrar("No fue posible conectar con la API local.")
            }
        })
    }

    private fun mostrarHospital(hospital: Hospital) {
        findViewById<LinearLayout>(R.id.tarjetaResultadoHospital).visibility = View.VISIBLE
        findViewById<TextView>(R.id.lblNombreHospital).text = hospital.NomHospital
        findViewById<TextView>(R.id.lblCapacidadHospital).text = "Capacidad: ${hospital.CapacidadAtencion}"
        findViewById<TextView>(R.id.lblEspecialidadesHospital).text = "Especialidades: ${hospital.Especialidades}"
    }

    private fun ocultarResultado() {
        findViewById<LinearLayout>(R.id.tarjetaResultadoHospital).visibility = View.GONE
    }

    private fun mostrar(mensaje: String) {
        Toast.makeText(this, mensaje, Toast.LENGTH_LONG).show()
    }
}

package sv.ues.aa13032.medcontrol.ui

import android.os.Bundle
import android.widget.ArrayAdapter
import android.widget.AutoCompleteTextView
import android.widget.Toast
import androidx.appcompat.app.AppCompatActivity
import com.google.android.material.button.MaterialButton
import com.google.android.material.textfield.TextInputEditText
import retrofit2.Call
import retrofit2.Callback
import retrofit2.Response
import sv.ues.aa13032.medcontrol.R
import sv.ues.aa13032.medcontrol.datos.modelos.Doctor
import sv.ues.aa13032.medcontrol.datos.modelos.Hospital
import sv.ues.aa13032.medcontrol.datos.modelos.RespuestaApi
import sv.ues.aa13032.medcontrol.datos.repositorios.RepositorioDoctor
import sv.ues.aa13032.medcontrol.datos.repositorios.RepositorioHospital
import sv.ues.aa13032.medcontrol.utilidades.ValidadorCampos

class RegistroDoctorActivity : AppCompatActivity() {
    private val repositorioDoctor = RepositorioDoctor()
    private val repositorioHospital = RepositorioHospital()

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_registro_doctor)

        cargarHospitales()

        findViewById<MaterialButton>(R.id.btnGuardarDoctor).setOnClickListener {
            registrarDoctor()
        }
    }

    private fun cargarHospitales() {
        repositorioHospital.listar().enqueue(object : Callback<RespuestaApi<List<Hospital>>> {
            override fun onResponse(
                call: Call<RespuestaApi<List<Hospital>>>,
                response: Response<RespuestaApi<List<Hospital>>>
            ) {
                val nombresHospitales = response.body()?.data.orEmpty().map { it.NomHospital }
                val adaptador = ArrayAdapter(
                    this@RegistroDoctorActivity,
                    android.R.layout.simple_dropdown_item_1line,
                    nombresHospitales
                )
                findViewById<AutoCompleteTextView>(R.id.txtHospitalDoctor).setAdapter(adaptador)
            }

            override fun onFailure(call: Call<RespuestaApi<List<Hospital>>>, t: Throwable) {
                mostrar("No fue posible cargar la lista de hospitales.")
            }
        })
    }

    private fun registrarDoctor() {
        val valores = mapOf(
            R.id.txtNombresDoctor to valor(R.id.txtNombresDoctor),
            R.id.txtApellidosDoctor to valor(R.id.txtApellidosDoctor),
            R.id.txtEspecialidadDoctor to valor(R.id.txtEspecialidadDoctor),
            R.id.txtTurnoAtencion to valor(R.id.txtTurnoAtencion),
            R.id.txtPacientesMinDiarios to valor(R.id.txtPacientesMinDiarios),
            R.id.txtSueldo to valor(R.id.txtSueldo),
            R.id.txtHospitalDoctor to valorHospital()
        )

        if (valores.values.any { ValidadorCampos.estaVacio(it) }) {
            mostrar("Complete todos los datos del doctor.")
            return
        }

        if (!ValidadorCampos.esEnteroPositivo(valores.getValue(R.id.txtPacientesMinDiarios))) {
            mostrar("Pacientes minimos diarios debe ser entero positivo.")
            return
        }

        if (!ValidadorCampos.esDecimalPositivo(valores.getValue(R.id.txtSueldo))) {
            mostrar("Sueldo debe ser un decimal positivo.")
            return
        }

        val doctor = Doctor(
            NombresDoctor = valores.getValue(R.id.txtNombresDoctor),
            ApellidosDoctor = valores.getValue(R.id.txtApellidosDoctor),
            Especialidad = valores.getValue(R.id.txtEspecialidadDoctor),
            TurnoAtencion = valores.getValue(R.id.txtTurnoAtencion),
            PacientesMinDiarios = valores.getValue(R.id.txtPacientesMinDiarios).toInt(),
            Sueldo = valores.getValue(R.id.txtSueldo).toDouble(),
            IdHospital = valores.getValue(R.id.txtHospitalDoctor)
        )

        repositorioDoctor.registrar(doctor).enqueue(object : Callback<RespuestaApi<Doctor>> {
            override fun onResponse(call: Call<RespuestaApi<Doctor>>, response: Response<RespuestaApi<Doctor>>) {
                val doctorRegistrado = response.body()?.data
                val mensaje = if (response.isSuccessful && doctorRegistrado?.IdDoctor != null) {
                    "${response.body()?.message} Codigo: ${doctorRegistrado.IdDoctor}"
                } else {
                    response.body()?.message ?: "No se pudo registrar el doctor."
                }
                mostrar(mensaje)
                if (response.isSuccessful) limpiarCampos()
            }

            override fun onFailure(call: Call<RespuestaApi<Doctor>>, t: Throwable) {
                mostrar("No fue posible conectar con la API local.")
            }
        })
    }

    private fun valor(id: Int): String = findViewById<TextInputEditText>(id).text?.toString().orEmpty()

    private fun valorHospital(): String = findViewById<AutoCompleteTextView>(R.id.txtHospitalDoctor)
        .text?.toString().orEmpty()

    private fun limpiarCampos() {
        listOf(
            R.id.txtNombresDoctor,
            R.id.txtApellidosDoctor,
            R.id.txtEspecialidadDoctor,
            R.id.txtTurnoAtencion,
            R.id.txtPacientesMinDiarios,
            R.id.txtSueldo
        ).forEach { findViewById<TextInputEditText>(it).setText("") }
        findViewById<AutoCompleteTextView>(R.id.txtHospitalDoctor).setText("")
    }

    private fun mostrar(mensaje: String) {
        Toast.makeText(this, mensaje, Toast.LENGTH_LONG).show()
    }
}

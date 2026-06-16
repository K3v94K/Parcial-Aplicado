package sv.ues.aa13032.medcontrol.ui

import android.content.Intent
import android.os.Bundle
import android.widget.TextView
import androidx.appcompat.app.AppCompatActivity
import com.google.android.material.button.MaterialButton
import retrofit2.Call
import retrofit2.Callback
import retrofit2.Response
import sv.ues.aa13032.medcontrol.R
import sv.ues.aa13032.medcontrol.datos.modelos.Doctor
import sv.ues.aa13032.medcontrol.datos.modelos.Hospital
import sv.ues.aa13032.medcontrol.datos.modelos.RespuestaApi
import sv.ues.aa13032.medcontrol.datos.repositorios.RepositorioDoctor
import sv.ues.aa13032.medcontrol.datos.repositorios.RepositorioHospital

class ActividadPrincipal : AppCompatActivity() {
    private val repositorioHospital = RepositorioHospital()
    private val repositorioDoctor = RepositorioDoctor()

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_principal)

        findViewById<MaterialButton>(R.id.btnRegistrarHospital).setOnClickListener {
            startActivity(Intent(this, RegistroHospitalActivity::class.java))
        }

        findViewById<MaterialButton>(R.id.btnBuscarHospital).setOnClickListener {
            startActivity(Intent(this, BusquedaHospitalActivity::class.java))
        }

        findViewById<MaterialButton>(R.id.btnRegistrarDoctor).setOnClickListener {
            startActivity(Intent(this, RegistroDoctorActivity::class.java))
        }

        findViewById<MaterialButton>(R.id.btnListarDoctores).setOnClickListener {
            startActivity(Intent(this, ListadoDoctoresActivity::class.java))
        }
    }

    override fun onResume() {
        super.onResume()
        cargarResumenModulo()
    }

    private fun cargarResumenModulo() {
        actualizarTotalHospitales()
        actualizarTotalDoctores()
    }

    private fun actualizarTotalHospitales() {
        repositorioHospital.listar().enqueue(object : Callback<RespuestaApi<List<Hospital>>> {
            override fun onResponse(
                call: Call<RespuestaApi<List<Hospital>>>,
                response: Response<RespuestaApi<List<Hospital>>>
            ) {
                val totalHospitales = response.body()?.data.orEmpty().size
                findViewById<TextView>(R.id.lblTotalHospitales).text = totalHospitales.toString()
            }

            override fun onFailure(call: Call<RespuestaApi<List<Hospital>>>, t: Throwable) {
                findViewById<TextView>(R.id.lblTotalHospitales).text = "0"
            }
        })
    }

    private fun actualizarTotalDoctores() {
        repositorioDoctor.listar().enqueue(object : Callback<RespuestaApi<List<Doctor>>> {
            override fun onResponse(
                call: Call<RespuestaApi<List<Doctor>>>,
                response: Response<RespuestaApi<List<Doctor>>>
            ) {
                val totalDoctores = response.body()?.data.orEmpty().size
                findViewById<TextView>(R.id.lblTotalDoctores).text = totalDoctores.toString()
            }

            override fun onFailure(call: Call<RespuestaApi<List<Doctor>>>, t: Throwable) {
                findViewById<TextView>(R.id.lblTotalDoctores).text = "0"
            }
        })
    }
}

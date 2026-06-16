package sv.ues.aa13032.medcontrol.ui

import android.os.Bundle
import android.widget.TextView
import androidx.appcompat.app.AppCompatActivity
import androidx.recyclerview.widget.LinearLayoutManager
import androidx.recyclerview.widget.RecyclerView
import retrofit2.Call
import retrofit2.Callback
import retrofit2.Response
import sv.ues.aa13032.medcontrol.R
import sv.ues.aa13032.medcontrol.datos.modelos.Doctor
import sv.ues.aa13032.medcontrol.datos.modelos.RespuestaApi
import sv.ues.aa13032.medcontrol.datos.repositorios.RepositorioDoctor

class ListadoDoctoresActivity : AppCompatActivity() {
    private val repositorioDoctor = RepositorioDoctor()

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_listado_doctores)

        findViewById<RecyclerView>(R.id.listaDoctores).layoutManager = LinearLayoutManager(this)
        cargarDoctores()
    }

    private fun cargarDoctores() {
        repositorioDoctor.listar().enqueue(object : Callback<RespuestaApi<List<Doctor>>> {
            override fun onResponse(
                call: Call<RespuestaApi<List<Doctor>>>,
                response: Response<RespuestaApi<List<Doctor>>>
            ) {
                val doctores = response.body()?.data.orEmpty()
                findViewById<TextView>(R.id.lblEstadoListado).text =
                    if (doctores.isEmpty()) {
                        "No hay medicos registrados."
                    } else {
                        "${doctores.size} medicos encontrados en la red MedControl."
                    }
                findViewById<RecyclerView>(R.id.listaDoctores).adapter = AdaptadorDoctores(doctores)
            }

            override fun onFailure(call: Call<RespuestaApi<List<Doctor>>>, t: Throwable) {
                findViewById<TextView>(R.id.lblEstadoListado).text =
                    "No fue posible conectar con la API local."
            }
        })
    }
}

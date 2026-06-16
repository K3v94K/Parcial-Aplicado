package sv.ues.aa13032.medcontrol.ui

import android.content.Intent
import android.os.Bundle
import androidx.appcompat.app.AppCompatActivity
import com.google.android.material.button.MaterialButton
import sv.ues.aa13032.medcontrol.R

class ActividadPrincipal : AppCompatActivity() {
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
}

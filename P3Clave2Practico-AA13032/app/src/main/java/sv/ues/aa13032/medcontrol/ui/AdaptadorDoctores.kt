package sv.ues.aa13032.medcontrol.ui

import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.TextView
import androidx.recyclerview.widget.RecyclerView
import sv.ues.aa13032.medcontrol.R
import sv.ues.aa13032.medcontrol.datos.modelos.Doctor

class AdaptadorDoctores(private val doctores: List<Doctor>) :
    RecyclerView.Adapter<AdaptadorDoctores.VistaDoctor>() {

    override fun onCreateViewHolder(parent: ViewGroup, viewType: Int): VistaDoctor {
        val vista = LayoutInflater.from(parent.context).inflate(R.layout.item_doctor, parent, false)
        return VistaDoctor(vista)
    }

    override fun onBindViewHolder(holder: VistaDoctor, position: Int) {
        holder.mostrar(doctores[position])
    }

    override fun getItemCount(): Int = doctores.size

    class VistaDoctor(itemView: View) : RecyclerView.ViewHolder(itemView) {
        fun mostrar(doctor: Doctor) {
            itemView.findViewById<TextView>(R.id.lblInicialDoctor).text =
                inicialesDoctor(doctor)
            itemView.findViewById<TextView>(R.id.lblNombreDoctor).text =
                "${doctor.NombresDoctor} ${doctor.ApellidosDoctor}"
            itemView.findViewById<TextView>(R.id.lblEspecialidadDoctor).text =
                doctor.Especialidad
            itemView.findViewById<TextView>(R.id.lblTurnoDoctor).text =
                doctor.TurnoAtencion
            itemView.findViewById<TextView>(R.id.lblPacientesDoctor).text =
                "${doctor.PacientesMinDiarios} diarios"
            itemView.findViewById<TextView>(R.id.lblSueldoDoctor).text =
                "$${doctor.Sueldo}"
            itemView.findViewById<TextView>(R.id.lblCodigoDoctor).text =
                doctor.IdDoctor ?: "Asignado"
            itemView.findViewById<TextView>(R.id.lblHospitalDoctor).text =
                "Hospital: ${doctor.NomHospital ?: doctor.IdHospital}"
        }

        private fun inicialesDoctor(doctor: Doctor): String {
            val primeraInicial = doctor.NombresDoctor.trim().firstOrNull()?.uppercaseChar() ?: 'D'
            val segundaInicial = doctor.ApellidosDoctor.trim().firstOrNull()?.uppercaseChar() ?: 'R'
            return "$primeraInicial$segundaInicial"
        }
    }
}

package sv.ues.aa13032.medcontrol.datos.modelos

data class Doctor(
    val IdDoctor: String? = null,
    val NombresDoctor: String,
    val ApellidosDoctor: String,
    val Especialidad: String,
    val TurnoAtencion: String,
    val PacientesMinDiarios: Int,
    val Sueldo: Double,
    val IdHospital: String,
    val NomHospital: String? = null
)

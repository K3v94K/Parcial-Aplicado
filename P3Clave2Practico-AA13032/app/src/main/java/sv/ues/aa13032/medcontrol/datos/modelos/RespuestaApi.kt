package sv.ues.aa13032.medcontrol.datos.modelos

data class RespuestaApi<T>(
    val success: Boolean,
    val message: String,
    val data: T?
)

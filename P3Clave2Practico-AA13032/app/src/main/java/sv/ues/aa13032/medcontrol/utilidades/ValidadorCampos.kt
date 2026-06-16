package sv.ues.aa13032.medcontrol.utilidades

object ValidadorCampos {
    fun estaVacio(valor: String): Boolean = valor.trim().isEmpty()

    fun esEnteroPositivo(valor: String): Boolean {
        return valor.toIntOrNull()?.let { it > 0 } == true
    }

    fun esDecimalPositivo(valor: String): Boolean {
        return valor.toDoubleOrNull()?.let { it > 0.0 } == true
    }
}

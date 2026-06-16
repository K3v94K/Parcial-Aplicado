package sv.ues.aa13032.medcontrol.datos.remoto

import retrofit2.Retrofit
import retrofit2.converter.gson.GsonConverterFactory

object ClienteApi {
    private const val URL_LOCAL_EMULADOR = "http://10.0.2.2:8088/"
    private const val URL_LOCAL_TELEFONO = "http://192.168.1.224:8088/"
    private const val URL_HOSTING = "https://reemplazar-con-url-del-hosting/"

    // Cambiar solo esta linea segun el ambiente de prueba.
    // Emulador Android: URL_LOCAL_EMULADOR
    // Telefono fisico en la misma red: URL_LOCAL_TELEFONO
    // API publicada en hosting: URL_HOSTING
    private const val URL_BASE = URL_LOCAL_TELEFONO

    val servicio: ServicioApi by lazy {
        Retrofit.Builder()
            .baseUrl(URL_BASE)
            .addConverterFactory(GsonConverterFactory.create())
            .build()
            .create(ServicioApi::class.java)
    }
}

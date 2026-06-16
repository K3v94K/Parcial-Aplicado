package sv.ues.aa13032.medcontrol.datos.remoto

import retrofit2.Call
import retrofit2.http.Body
import retrofit2.http.GET
import retrofit2.http.POST
import retrofit2.http.Path
import sv.ues.aa13032.medcontrol.datos.modelos.Doctor
import sv.ues.aa13032.medcontrol.datos.modelos.Hospital
import sv.ues.aa13032.medcontrol.datos.modelos.RespuestaApi

interface ServicioApi {
    @POST("hospitales")
    fun registrarHospital(@Body hospital: Hospital): Call<RespuestaApi<Hospital>>

    @GET("hospitales/{id}")
    fun buscarHospital(@Path("id") idHospital: String): Call<RespuestaApi<Hospital>>

    @GET("hospitales")
    fun listarHospitales(): Call<RespuestaApi<List<Hospital>>>

    @POST("doctores")
    fun registrarDoctor(@Body doctor: Doctor): Call<RespuestaApi<Doctor>>

    @GET("doctores")
    fun listarDoctores(): Call<RespuestaApi<List<Doctor>>>
}

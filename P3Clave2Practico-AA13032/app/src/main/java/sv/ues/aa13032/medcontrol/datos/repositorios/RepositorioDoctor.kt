package sv.ues.aa13032.medcontrol.datos.repositorios

import retrofit2.Call
import sv.ues.aa13032.medcontrol.datos.modelos.Doctor
import sv.ues.aa13032.medcontrol.datos.modelos.RespuestaApi
import sv.ues.aa13032.medcontrol.datos.remoto.ClienteApi

class RepositorioDoctor {
    fun registrar(doctor: Doctor): Call<RespuestaApi<Doctor>> {
        return ClienteApi.servicio.registrarDoctor(doctor)
    }

    fun listar(): Call<RespuestaApi<List<Doctor>>> {
        return ClienteApi.servicio.listarDoctores()
    }
}

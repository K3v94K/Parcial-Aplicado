package sv.ues.aa13032.medcontrol.datos.repositorios

import retrofit2.Call
import sv.ues.aa13032.medcontrol.datos.modelos.Hospital
import sv.ues.aa13032.medcontrol.datos.modelos.RespuestaApi
import sv.ues.aa13032.medcontrol.datos.remoto.ClienteApi

class RepositorioHospital {
    fun registrar(hospital: Hospital): Call<RespuestaApi<Hospital>> {
        return ClienteApi.servicio.registrarHospital(hospital)
    }

    fun buscarPorId(idHospital: String): Call<RespuestaApi<Hospital>> {
        return ClienteApi.servicio.buscarHospital(idHospital)
    }

    fun listar(): Call<RespuestaApi<List<Hospital>>> {
        return ClienteApi.servicio.listarHospitales()
    }
}

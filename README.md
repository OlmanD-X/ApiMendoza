## ApiMendoza v 1.0

# Empresas:

    (apiMendoza/Empresas/ctrCrearEmpresa)
    - ctrCrearEmpresa : Crear una nueva empresa
        new_empRS : razon social,
        new_empRUC : ruc,
        new_empLogo : logo de la empresa

    (apiMendoza/Empresas/ctrEditarEmpresa)
    - ctrEditarEmpresa : Editar una empresa
        edit_empRS : razon social,
        edit_empRUC : ruc,
        Id_Empresa : id de la empresa a editar

    (apiMendoza/Empresas/ctrEliminarEmpresa/idEmpresa)
    - ctrEliminarEmpresa : Elimina una empresa

    (apiMendoza/Empresas/ctrMostrarEmpresas)
    - ctrMostrarEmpresas : Lista todas las empresas

    (apiMendoza/Empresas/ctrMostrarEmpresas/campoBusqueda/valor)
    - ctrMostrarEmpresas

# Objetivos Estratégicos:

    (apiMendoza/Obj_Estra/ctrCrear_objEstrategico)
    - ctrCrear_objEstrategico : Registrar un objetivo estratégico
        new_oeDesc : descripción,
        Id_Empresa : id de la empresa

    (apiMendoza/Obj_Estra/ctrEditar_objEstrategico)
    - ctrEditar_objEstrategico: editar un objetivo estratégico
        edit_oeDesc : descripción,
        Id_ObjEstra : id del objetivo,
        Id_Emp : id de la empresa

    (apiMendoza/Obj_Estra/ctrEliminar_objEstrategico/idObjetivo)
    - ctrEliminar_objEstrategico : eliminar un objetivo

    (apiMendoza/Obj_Estra/ctrMostrar_objEstrategicos)
    - ctrMostrar_objEstrategicos : Lista todas las empresas

    (apiMendoza/Obj_Estra/ctrMostrar_objEstrategicos/campoBusqueda/valor)
    - ctrMostrar_objEstrategicos

# Procesos:

    (apiMendoza/Procesos/addProceso)
    - addProceso : agrega un nuevo proceso
        descripcion : descripción del proceso,
        idEmpresa : id de la empresa

    (apiMendoza/Procesos/updateProceso)
    - updateProceso : edita un proceso
        descripcion : descripción del proceso,
        idEmpresa : id de la empresa,
        idProceso : id del proceso

    (apiMendoza/Procesos/deleteProceso/idProceso)  method: GET
    - deleteProceso : eliminar un proceso

    (apiMendoza/Procesos/getAllProcesos/idEmpresa)  method: GET
    - getAllProcesos : obtener todos los procesos

    (apiMendoza/Procesos/getProceso/idProceso)  method: GET
    - getProceso : obtener un proceso

# Objetivos del Proceso

    (apiMendoza/ObjetivosProceso/addObjetivosProceso)
    - addObjetivosProceso : agrega un nuevo objetivo del proceso
        descripcion : descripción del objetivo,
        idProceso : id del proceso

    (apiMendoza/ObjetivosProceso/updateObjetivosProceso)
    - updateObjetivosProceso : edita un objetivo del proceso
        descripcion : descripción del objetivo,
        idObjetivo : id del objetivo,
        idProceso : id del proceso

    (apiMendoza/ObjetivosProceso/deleteObjetivosProceso/idObjetivo)  method: GET
    - deleteObjetivosProceso : eliminar un objetivo del proceso

    (apiMendoza/ObjetivosProceso/getAllObjetivosProceso/idProceso)  method: GET
    - getAllObjetivosProceso : obtener todos los objetivos de un proceso

    (apiMendoza/ObjetivosProceso/getObjetivosProceso/idObjetivo)  method: GET
    - getObjetivosProceso : obtener un proceso

# Subprocesos

    (apiMendoza/SubProcesos/addSubProceso)
    - addSubProceso : agrega un nuevo subproceso
        descripcion : descripción del proceso,
        idProceso : id del proceso

    (apiMendoza/SubProcesos/updateSubProceso)
    - updateSubProceso : edita un subproceso
        descripcion : descripción del proceso,
        idSubproceso : id del subproceso,
        idProceso : id del proceso

    (apiMendoza/SubProcesos/deleteSubProceso/idSubProceso)  method: GET
    - deleteSubProceso : eliminar un subproceso

    (apiMendoza/SubProcesos/getAllSubProcesos/idProceso)  method: GET
    - getAllSubProcesos : obtener todos los subprocesos

    (apiMendoza/SubProcesos/getSubProceso/idSubProceso)  method: GET
    - getSubProceso : obtener un subproceso

# Mapa Estratégico

    (apiMendoza/Mapa_ests/add)
    - add : agrega un nuevo mapa estratégico
        ME_PROC_ID : id del proceso, (NULL)
        ME_SUB_ID : id del subproceso (NULL)

    (apiMendoza/Mapa_ests/update/idMapaEstratégico)
    - update : da de baja un mapa estratégico

    (apiMendoza/Mapa_ests/delete/idMapaEstratégico)
    - delete : eliminar un subproceso

    (apiMendoza/Mapa_ests/getAll/tipoProceso/idProceso) 'tipoProceso' = 'proceso' | 'subproceso'
    - getAll : obtener todos los subprocesos

    (apiMendoza/Mapa_ests/getOne/idMapaEstratégico)
    - getOne : obtener un mapa estratégico

# Perspectivas

    (apiMendoza/Perspectivas/add)
    - add : agrega un nuevo mapa estratégico
        PERS_NAME : nombre perspectiva,
        PERS_ORDEN : orden de la perspectiva,
        PERS_ME_ID : mapa estratégico id

    (apiMendoza/Perspectivas/update/)
    - update : da de baja un mapa estratégico
        PERS_NAME : nombre perspectiva,
        PERS_ORDEN : orden de la perspectiva,
        PERS_ME_ID : mapa estratégico id,
        PERS_ID : id de la perspectiva

    (apiMendoza/Perspectivas/delete/idPerspectiva)
    - delete : eliminar una perspectiva

    (apiMendoza/Perspectivas/getAll/idMapaEstratégico)
    - getAll : obtener todas las perspectivas

    (apiMendoza/Perspectivas/getOne/idPerspectiva)
    - getOne : obtener una perspectiva

# Detalle Mapa Estratégico

    (apiMendoza/Detalles_me/add)
    - add : agrega un nuevo mapa estratégico
        DET_OBJ_ID : id del objetivo del proceso, (NULL)
        DET_OE_ID : id del objetivo estratégico, (NULL)
        DET_PERS_ID : id de la perspectiva,
        ME_ID : id del mapa estratégico,
        type : tipo del objetivo - del proceso | estratégico

    (apiMendoza/Detalles_me/update/)
    - update : INNECESARIO

    (apiMendoza/Detalles_me/delete/idDetalle)
    - delete : eliminar un detalle del mapa estratpegico

    (apiMendoza/Detalles_me/getAll/idMapaEstratégico)
    - getAll : obtener todos los detalles del mapa

    (apiMendoza/Detalles_me/getOne/idPerspectiva)
    - getOne : obtener un detalle del mapa

# Relaciones Objetivos

    (apiMendoza/Relaciones_objetivos/add)
    - add : agrega una nueva relación
        REL_OBJ_ID : id del objetivo del proceso, (NULL)
        REL_OE_ID : id del objetivo estratégico, (NULL)
        REL_DET_ID : id del detalle

    (apiMendoza/Relaciones_objetivos/update/)
    - update : edita una relación
        REL_OBJ_ID : id del objetivo del proceso, (NULL)
        REL_OE_ID : id del objetivo estratégico, (NULL)
        REL_DET_ID : id del detalle,
        REL_ID : id de la relación

    (apiMendoza/Relaciones_objetivos/delete/idRelación)
    - delete : eliminar una relación

    (apiMendoza/Relaciones_objetivos/getAll/idDetalle)
    - getAll : obtener todas las relacionesa

    (apiMendoza/Relaciones_objetivos/getOne/idRelación)
    - getOne : obtener una relación

# Indicadores
    (apiMendoza/Indicators/add)
    - add : agrega un nuevo indicador
        name : nombre del indicador,
        responsable : responsable del indicador,
        objetivo : objetivo del indicador,
        lineabase : linea base del indicador,
        meta : meta del indicador,
        frecuencia: frecuencia del indicador,
        formula : formula del indicador,
        redSymbol : signo del color rojo,
        yellowSymbol : signo del color amarillo,
        greenSymbol : signo del color verde,
        redValue : valor del color rojo,
        yellowValue : valor del color amarillo,
        greenValue : valor del color verde,
        tipoProceso : si es proceso o subproceso,
        idProceso : id del proceso o subproceso,
        variables : array de objetos de variables enviado en formato json, el objeto debe contener los campos symbol y desc,
        iniciativas : array de objetos de iniciativas enviado en formato json, el objeto debe contener el campo desc

    (apiMendoza/Indicators/update/)
    - update : edita una relación
        name : nombre del indicador,
        responsable : responsable del indicador,
        objetivo : objetivo del indicador,
        lineabase : linea base del indicador,
        meta : meta del indicador,
        frecuencia: frecuencia del indicador,
        formula : formula del indicador,
        redSymbol : signo del color rojo,
        yellowSymbol : signo del color amarillo,
        greenSymbol : signo del color verde,
        redValue : valor del color rojo,
        yellowValue : valor del color amarillo,
        greenValue : valor del color verde,
        tipoProceso : si es proceso o subproceso,
        idProceso : id del proceso o subproceso,
        variables : array de objetos de variables enviado en formato json, el objeto debe contener los campos symbol y desc,
        iniciativas : array de objetos de iniciativas enviado en formato json, el objeto debe contener el campo desc,
        id : id del indicador

    (apiMendoza/Indicators/delete/idIndicador)
    - delete : eliminar un indicador

    (apiMendoza/Indicators/getAll)
    - getAll : obtener todos los indicadores

    (apiMendoza/Indicators/getAllByProceso/tipoProceso/idProceso)
    - getAllByProceso : obtener todos los indicadores por proceso

    (apiMendoza/Indicators/get/idIndicador)
    - getOne : obtener un indicador

# Variables

# Iniciativas


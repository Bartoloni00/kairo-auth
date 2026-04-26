cada accion en el sistema registrara un log en la tabla audit_logs

la estructura de la tabla es la siguiente:

- ID del usuario
- Horario
- Accion
    - Agregado exitoso
    - Eliminacion exitosa
    - Actualizacion exitosa
    - Fallo eliminado
    - Fallo agregado
    - Fallo actualizacion

    - Login exitoso
    - Fallo de login

- Metada {
  endpoint,
  IP (existe un helper llamado requestIP()),
  request_headers (existe un helper llamado requestHeaders()),
  request_params (existe un helper llamado requestParams()),
  request_body (existe un helper llamado requestBody()),
  }

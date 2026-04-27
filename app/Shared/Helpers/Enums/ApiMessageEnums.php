<?php

namespace App\Shared\Helpers\Enums;

enum ApiMessageEnum: string
{
  public const UNAUTHORIZED_MESSAGE = 'No tienes permiso para realizar esta acción';
  public const FORBIDDEN_MESSAGE = 'Acción no permitida';
  public const INVALID_REQUEST = 'Solicitud inválida';
  public const TOKEN_EXPIRED = 'Token expirado';
  public const TOKEN_INVALID = 'Token inválido';
  public const TOKEN_NOT_PROVIDED = 'Token no proporcionado';
  public const USER_NOT_FOUND = 'Usuario no encontrado';
  public const PROJECT_NOT_FOUND = 'Proyecto no encontrado';
  public const ORGANIZATION_NOT_FOUND = 'Organización no encontrada';
  public const ROLE_NOT_FOUND = 'Rol no encontrado';
  public const USER_NOT_IN_PROJECT = 'Usuario no pertenece al proyecto';
  public const USER_NOT_IN_ORGANIZATION = 'Usuario no pertenece a la organización';
  public const DELETE_FAILED = 'Eliminación fallida';
  public const UPDATE_FAILED = 'Actualización fallida';
  public const USER_DELETED_SUCCESSFULLY = 'Usuario eliminado exitosamente';
  public const USER_ADDED_TO_PROJECT_SUCCESSFULLY = 'Usuario agregado al proyecto exitosamente';
  public const USER_ADDED_TO_ORGANIZATION_SUCCESSFULLY = 'Usuario agregado a la organización exitosamente';
  public const USER_REMOVED_FROM_PROJECT_SUCCESSFULLY = 'Usuario eliminado del proyecto exitosamente';
  public const USER_REMOVED_FROM_ORGANIZATION_SUCCESSFULLY = 'Usuario eliminado de la organización exitosamente';
  public const USER_EMAIL_UPDATED_SUCCESSFULLY = 'Email del usuario actualizado exitosamente';
  public const USER_PASSWORD_UPDATED_SUCCESSFULLY = 'Contraseña del usuario actualizada exitosamente';
}

import { ConfirmNotification, Notification } from './index'
import { parseActions } from './actions'
import { parseEvents } from './events'
import { parseIcon } from './icons'
import { ConfirmationOptions, defaultOptions, Options } from './options'

export interface LivewireOptions {
  id: string,
  method: string,
  params?: any
}

export interface ParseLivewire {
  (options: LivewireOptions): CallableFunction
}

export interface ParseNotification {
  (options: Options, componentId?: string): Notification
}

export interface ParseConfirmation {
  (options: ConfirmationOptions, componentId?: string): ConfirmNotification
}

export const parseRedirect = (redirect: string): CallableFunction => {
  return () => { window.location.href = redirect }
}

export const parseLivewire: ParseLivewire = ({ id, method, params = undefined }) => {
  return () => {
    const component = window.Livewire.find(id)

    if (params !== undefined) {
      return Array.isArray(params)
        ? component?.call(method, ...params)
        : component?.call(method, params)
    }

    component?.call(method)
  }
}

export const parseNotification: ParseNotification = (options, componentId?): Notification => {
  const notification = Object.assign(defaultOptions, options) as Notification

  if (typeof options.icon === 'string') {
    notification.icon = parseIcon({ name: options.icon, color: options.iconColor })
  }

  const { onClose, onDismiss, onTimeout } = parseEvents(options, componentId)

  return {
    ...notification,
    onClose,
    onDismiss,
    onTimeout
  }
}

export const parseConfirmation: ParseConfirmation = (options, componentId?): ConfirmNotification => {
  const notification = parseNotification(options, componentId)

  const { accept, reject } = parseActions(options, componentId)

  return {
    ...notification,
    accept,
    reject
  }
}
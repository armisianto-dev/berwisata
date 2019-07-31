export interface LoginResponse {
  error: Array<Error>
  message: string
  status: boolean
  title: string
  token: string
}

export interface Error {
  code: string
  message: Array<Messages>
}

export interface Messages {
  [key: string]: string
}

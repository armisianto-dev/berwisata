export interface AuthResponse {
  error: Array<Error>
  message: string
  status: boolean
  title: string
  token: string
}

export interface Error {
  code: string
  message: string
}

import { FormGroup } from '@angular/forms'

export function matchingValue(source: string, confirm: string) {
  return (group: FormGroup): { [key: string]: any } => {
    let sourceValue = group.controls[source].value
    let confirmValue = group.controls[confirm].value

    if (sourceValue !== confirmValue) {
      return { missMatchValue: true }
    }
  }
}

export function numberOnly(source: string) {
  return (group: FormGroup): { [key: string]: any } => {
    let sourceValue = group.controls[source].value

    if (sourceValue === null) {
      return null
    }

    let number = sourceValue.toString()

    var valid = number.match(/^\d+$/)
    return valid ? null : { notValidNumberOnly: true }
  }
}

export function leadingZero(source: string) {
  return (group: FormGroup): { [key: string]: any } => {
    let sourceValue = group.controls[source].value

    let number = sourceValue.toString()
    var valid = number.match(/^0+/)
    return valid ? null : { notValidLeadingZero: true }
  }
}

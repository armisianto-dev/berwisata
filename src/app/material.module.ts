import { CommonModule } from '@angular/common'
import { NgModule } from '@angular/core'
import {
  MatButtonModule,
  MatIconModule,
  MatMenuModule,
  MatToolbarModule,
} from '@angular/material'

@NgModule({
  declarations: [],
  imports: [
    CommonModule,
    MatToolbarModule,
    MatIconModule,
    MatButtonModule,
    MatMenuModule,
  ],
  exports: [MatToolbarModule, MatIconModule, MatButtonModule, MatMenuModule],
})
export class MaterialModule {}

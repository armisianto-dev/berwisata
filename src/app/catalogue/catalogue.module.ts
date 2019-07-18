import { CommonModule } from '@angular/common'
import { NgModule } from '@angular/core'
import { MaterialModule } from '../material.module'
import { CatalogueRoutingModule } from './catalogue-routing.module'
import { CatalogueComponent } from './catalogue.component'

@NgModule({
  declarations: [CatalogueComponent],
  imports: [CommonModule, CatalogueRoutingModule, MaterialModule],
})
export class CatalogueModule {}

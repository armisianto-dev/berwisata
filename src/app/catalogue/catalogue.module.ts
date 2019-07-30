import { CommonModule } from '@angular/common'
import { NgModule } from '@angular/core'
import { FormsModule } from '@angular/forms'
import { MatProgressSpinnerModule, MatTabsModule } from '@angular/material'
import { NgbModule } from '@ng-bootstrap/ng-bootstrap'
import { MaterialModule } from '../material.module'
import { CatalogueDetailComponent } from './catalogue-detail/catalogue-detail.component'
import { CatalogueRoutingModule } from './catalogue-routing.module'
import { CatalogueComponent } from './catalogue.component'

@NgModule({
  declarations: [CatalogueComponent, CatalogueDetailComponent],
  imports: [
    CommonModule,
    CatalogueRoutingModule,
    MaterialModule,
    MatTabsModule,
    NgbModule,
    MatProgressSpinnerModule,
    FormsModule,
  ],
})
export class CatalogueModule {}

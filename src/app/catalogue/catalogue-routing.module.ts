import { NgModule } from '@angular/core'
import { RouterModule, Routes } from '@angular/router'
import { CatalogueComponent } from './catalogue.component'

const routes: Routes = [
  {
    path: '',
    component: CatalogueComponent,
    children: [{ path: '', redirectTo: '/catalogue', pathMatch: 'full' }],
  },
]

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class CatalogueRoutingModule {}

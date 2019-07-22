import { Component, OnInit } from '@angular/core'
import { RouterServiceService } from 'src/app/services/router-service/router-service.service'

@Component({
  selector: 'app-catalogue-detail',
  templateUrl: './catalogue-detail.component.html',
  styleUrls: ['./catalogue-detail.component.css'],
})
export class CatalogueDetailComponent implements OnInit {
  constructor(private routerService: RouterServiceService) {}

  ngOnInit() {
    this.routerService.changeRouteData('nav_title', 'Bali 3D2N')
  }
}

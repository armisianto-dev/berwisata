import { Component, OnInit } from '@angular/core'
import { Title } from '@angular/platform-browser'
import { RouterServiceService } from 'src/app/services/router-service/router-service.service'

@Component({
  selector: 'app-catalogue-detail',
  templateUrl: './catalogue-detail.component.html',
  styleUrls: ['./catalogue-detail.component.css'],
})
export class CatalogueDetailComponent implements OnInit {
  constructor(private routerService: RouterServiceService, private titleService: Title) {}

  ngOnInit() {
    this.routerService.changeRouteData('nav_title', 'Paket Bali 3D2N')
    this.titleService.setTitle('Bali 3D2N | Berwisata')
  }
}

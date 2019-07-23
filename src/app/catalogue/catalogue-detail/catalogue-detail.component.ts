import { Component, OnInit } from '@angular/core'
import { Title } from '@angular/platform-browser'
import { ActivatedRoute } from '@angular/router'
import { RouterServiceService } from 'src/app/services/router-service/router-service.service'

@Component({
  selector: 'app-catalogue-detail',
  templateUrl: './catalogue-detail.component.html',
  styleUrls: ['./catalogue-detail.component.css'],
})
export class CatalogueDetailComponent implements OnInit {
  catalogueId: string
  constructor(
    private route: ActivatedRoute,
    private routerService: RouterServiceService,
    private titleService: Title
  ) {}

  ngOnInit() {
    this.catalogueId = this.route.snapshot.params.catalogueId
    this.routerService.changeRouteData('nav_title', 'Paket Bali 3D2N ' + this.catalogueId)
    this.titleService.setTitle('Bali 3D2N | Berwisata')
  }
}

import { Component, OnInit } from '@angular/core'
import { Title } from '@angular/platform-browser'
import { ActivatedRoute } from '@angular/router'
import { Observable } from 'rxjs'
import { CatalogueDetail } from 'src/app/model/catalogue/catalogue-detail'
import { CatalogueService } from 'src/app/services/catalogue/catalogue.service'
import { RouterServiceService } from 'src/app/services/router-service/router-service.service'

@Component({
  selector: 'app-catalogue-detail',
  templateUrl: './catalogue-detail.component.html',
  styleUrls: ['./catalogue-detail.component.css'],
})
export class CatalogueDetailComponent implements OnInit {
  showLoading: boolean = true
  catalogueId: string

  catalogueDetailObservable: Observable<CatalogueDetail>

  constructor(
    private route: ActivatedRoute,
    private routerService: RouterServiceService,
    private titleService: Title,
    private catalogueService: CatalogueService
  ) {}

  ngOnInit() {
    this.catalogueId = this.route.snapshot.params.catalogueId

    setTimeout(() => {
      this.catalogueDetailObservable = this.catalogueService.get_detail_catalogue(
        this.catalogueId
      )

      this.catalogueDetailObservable.subscribe(() => (this.showLoading = false))
      this.catalogueDetailObservable.subscribe(res =>
        this.routerService.changeRouteData('nav_title', res.paket_nama)
      )
      this.catalogueDetailObservable.subscribe(res =>
        this.titleService.setTitle(res.paket_nama + ' | Berwisata')
      )
    }, 500)
  }
}

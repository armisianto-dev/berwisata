import { Component, OnInit } from '@angular/core'
import { NgbCarouselConfig } from '@ng-bootstrap/ng-bootstrap'
import { Observable } from 'rxjs'
import { CatalogueList } from 'src/app/model/catalogue/catalogue-list'
import { CatalogueService } from 'src/app/services/catalogue/catalogue.service'

@Component({
  selector: 'app-home',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.css'],
  providers: [NgbCarouselConfig],
})
export class HomeComponent implements OnInit {
  showNavigationArrows = true
  showNavigationIndicators = true
  images = [
    {
      image_url: 'assets/images/paket_wisata/bali.jpg',
      caption_label: '',
    },
    {
      image_url: 'assets/images/paket_wisata/jogja.jpg',
      caption_label: '',
    },
    {
      image_url: 'assets/images/paket_wisata/bromo.jpg',
      caption_label: '',
    },
  ]

  listPromo: Observable<CatalogueList[]>

  constructor(config: NgbCarouselConfig, private catalogueService: CatalogueService) {
    config.showNavigationArrows = true
    config.showNavigationIndicators = true
  }

  ngOnInit() {
    this.listPromo = this.catalogueService.get_all_catalogue_promo()
  }
}

import { HttpClient } from '@angular/common/http'
import { Injectable } from '@angular/core'
import { CatalogueDetail } from 'src/app/model/catalogue/catalogue-detail'
import { CatalogueList } from 'src/app/model/catalogue/catalogue-list'
import { environment } from 'src/environments/environment'

@Injectable({
  providedIn: 'root',
})
export class CatalogueService {
  baseUrl = environment.web_services
  constructor(private httpClient: HttpClient) {}

  get_catalogue_pagination() {
    return this.httpClient.get(
      this.baseUrl + 'wisata/paket_wisata/pagination_paket_wisata'
    )
  }

  get_all_catalogue_lists(page?: number, per_page?: number) {
    return this.httpClient.get<CatalogueList[]>(
      this.baseUrl +
        'wisata/paket_wisata/all_paket_wisata?page=' +
        page +
        '&per_page=' +
        per_page
    )
  }

  get_detail_catalogue(paket_id: any) {
    return this.httpClient.get<CatalogueDetail>(
      this.baseUrl + 'wisata/paket_wisata/detail_paket_wisata?paket_id=' + paket_id
    )
  }
}

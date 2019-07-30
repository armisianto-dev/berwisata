import { Component, OnInit } from '@angular/core'
import { Observable } from 'rxjs'
import { CatalogueList } from '../model/catalogue/catalogue-list'
import { CatalogueSearch } from '../model/catalogue/catalogue-search'
import { PaginationConfig } from '../model/pagination/pagination-config'
import { CatalogueService } from '../services/catalogue/catalogue.service'

@Component({
  selector: 'app-catalogue',
  templateUrl: './catalogue.component.html',
  styleUrls: ['./catalogue.component.css'],
})
export class CatalogueComponent implements OnInit {
  showLoading: boolean = true
  currPage: number = 1
  paginationPerPage: number = 2
  paginationTotal: number = 0
  paginationConfig: PaginationConfig

  catalogueSearchData: CatalogueSearch = { city: '' }
  catalogueListsObservable: Observable<CatalogueList[]>

  constructor(private catalogueService: CatalogueService) {}

  onSearchSubmit(searchForm) {
    this.catalogueSearchData = searchForm.value
    this.setPagination()
    this.onPageChange(1)
  }

  setPagination() {
    this.catalogueService
      .get_catalogue_pagination(this.catalogueSearchData.city)
      .subscribe((res: PaginationConfig) => {
        this.paginationTotal = res.total
      })
  }

  onPageChange(page: number) {
    this.showLoading = true
    setTimeout(() => {
      this.catalogueListsObservable = this.catalogueService.get_all_catalogue_lists(
        page,
        this.paginationPerPage,
        this.catalogueSearchData.city
      )
      this.currPage = page
      this.showLoading = false
    }, 1000)
  }

  ngOnInit() {
    this.currPage = 1
    this.paginationPerPage = 2

    setTimeout(() => {
      this.catalogueListsObservable = this.catalogueService.get_all_catalogue_lists(
        this.currPage,
        this.paginationPerPage,
        this.catalogueSearchData.city
      )
      this.catalogueListsObservable.subscribe(() => (this.showLoading = false))
    }, 1000)

    this.setPagination()
  }
}

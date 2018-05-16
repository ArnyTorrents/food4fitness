import { Component, OnInit } from '@angular/core';

import { Products } from './../model/products';
import { ProductType} from './../model/productType';

//Service
import { ProductDataService } from './../services/product-data.service';

@Component({
  selector: 'app-product-detail',
  templateUrl: './../views/product-detail.view.html',
  styleUrls: ['./../css/product-detail.style.css'],
  providers: [ProductDataService]
})
export class ProductDetailComponent implements OnInit {

  pageTitle: string = 'Product Detail';
  product: Products[];
  errorMessage: string;

  constructor() { }

  ngOnInit() {
  }

}

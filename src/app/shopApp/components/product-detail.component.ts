import { Component, OnInit,ViewChild,
  Input, Output, EventEmitter  } from '@angular/core';

import { Products } from './../model/products';
import { ProductType} from './../model/productType';

//Service
import { ProductDataService } from './../services/product-data.service';

@Component({
  selector: 'product-detail',
  templateUrl: './../views/product-detail.view.html',
  styleUrls: ['./../css/product-detail.style.css'],
  providers: [ProductDataService]
})
export class ProductDetailComponent implements OnInit {

  pageTitle: string = 'Product Detail';
  shopAction: number;
  errorMessage: string;


  @Input() product : Products;
  @Input() productsType : ProductType[];

  // We'll use
  //setShopAction.emit(variable Content to comunicate)
  @Output() setShopAction:EventEmitter<number>
              = new EventEmitter<number>();

  constructor() { }

  ngOnInit() {
  }

  getProduct(id: number) {
    // this._productService.getProduct(id).subscribe(
    //   product => this.product = product,
    //   error => this.errorMessage = <any>error);
  }

  setShopActionDetail(action:number): void {
    this.shopAction=action;
  }
}

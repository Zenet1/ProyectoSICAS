import { Component, OnInit, ViewChild } from '@angular/core';
import { ZXingScannerComponent } from '@zxing/ngx-scanner';

@Component({
  selector: 'app-scanner',
  templateUrl: './scanner.component.html',
  styleUrls: ['./scanner.component.css']
})
export class ScannerComponent implements OnInit {
  @ViewChild(ZXingScannerComponent) scanner: ZXingScannerComponent;
  resultadoEscaneo: any;
  escaneoRealizado:boolean =false;
  constructor() { }

  ngOnInit(): void {

  }

  nuevoEscaneo(){
    this.scanner.enable = true;
    this.escaneoRealizado = false;
  }

  scanSuccessHandler(event){
    this.scanner.enable = false;
    this.escaneoRealizado = true;
    this.resultadoEscaneo = event;
  }

  verificar(){
    if(this.resultadoEscaneo != null){
        alert(this.resultadoEscaneo);
        
    }
  }

  scanErrorHandler(event){
      
  }

  scanFailureHandler(event){

  }

  scanCompleteHandler(event){

  }
}
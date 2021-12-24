import { Component, OnInit, ViewChild } from '@angular/core';
import { Router } from '@angular/router';
import { ZXingScannerComponent } from '@zxing/ngx-scanner';
import { CapturadorService } from 'src/app/services/capturador/capturador.service';

@Component({
  selector: 'app-scanner',
  templateUrl: './scanner.component.html',
  styleUrls: ['./scanner.component.css']
})
export class ScannerComponent implements OnInit {
  @ViewChild(ZXingScannerComponent) scanner: ZXingScannerComponent;
  resultadoEscaneo: any;
  escaneoRealizado:boolean = false;
  resultadoValidacion:boolean;
  camaras:any;
  constructor(private servicioCapturador:CapturadorService, private router:Router) { }

  ngOnInit(): void {
    //console.log(this.resultadoValidacion);
  }

  nuevoEscaneo(){
    //this.scanner.enable = true;
    this.scanner.scanStart();
    this.escaneoRealizado = false;
    this.resultadoValidacion = null;
  }

  scanSuccessHandler(event){
    //this.scanner.enable = false;
    this.scanner.scanStop();
    this.escaneoRealizado = true;
    this.resultadoEscaneo = event;
    alert(this.resultadoEscaneo);
  }

  verificar(){
    //this.resultadoValidacion = false;
    if(this.resultadoEscaneo != null){
      //alert(this.resultadoEscaneo);
      this.servicioCapturador.verficar(this.resultadoEscaneo).subscribe(
        respuesta =>{
          if(respuesta = "valido"){
            this.resultadoValidacion = true;
          } else {
            this. resultadoValidacion = false;
          }
        }
      );
    }
  }

  cancelar(){
    this.scanner.askForPermission();
    //location.href = '/inicio-capturador';
    //this.router.navigateByUrl('inicio-capturador');
  }

  camerasFoundHandler(event){
    this.camaras = event;
    console.log(this.camaras);
  }

  scanErrorHandler(event){ }

  scanFailureHandler(event){ }

  scanCompleteHandler(event){ }
}
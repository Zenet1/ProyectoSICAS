import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup } from '@angular/forms';
import { Router } from '@angular/router';
import { AsistenciaExternoService } from 'src/app/services/asistencia-externo/asistencia-externo.service';

@Component({
  selector: 'app-asistencia-externo',
  templateUrl: './asistencia-externo.component.html',
  styleUrls: ['./asistencia-externo.component.css']
})
export class AsistenciaExternoComponent implements OnInit {
  oficinas:any;
  formularioAsistenciaExternno:FormGroup;

  constructor(private servicioAsistenciaExterno:AsistenciaExternoService, private formBuilder:FormBuilder, private router:Router) { }

  ngOnInit(): void {
    this.formularioAsistenciaExternno = this.formBuilder.group({
      oficinas: [""],
      accion: [""],
    }
  );
  }

  enviarAsistencia(){
    if (window.confirm("Si está seguro que desea asistir, confirme para finalizar")) {
      this.formularioAsistenciaExternno.controls["oficinas"].setValue(this.oficinas);
      this.formularioAsistenciaExternno.controls["accion"].setValue("aceptado");
      this.servicioAsistenciaExterno.enviarAsistencia(this.formularioAsistenciaExternno.value).subscribe(
        respuesta=>{
          this.router.navigateByUrl('inicio-externo');
        }
      );
    }
  }

  cancelar(){
    this.router.navigateByUrl('login');
  }
}

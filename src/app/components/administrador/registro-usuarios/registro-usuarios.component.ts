import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup } from '@angular/forms';
import { AdministradorService } from 'src/app/services/administrador/administrador.service';

@Component({
  selector: 'app-registro-usuarios',
  templateUrl: './registro-usuarios.component.html',
  styleUrls: ['./registro-usuarios.component.css']
})
export class RegistroUsuariosComponent implements OnInit {
  
  formularioRegistrarUsuario:FormGroup;
  roles:any;

  constructor(private servicioAdmin:AdministradorService, private formBuilder:FormBuilder) { }

  ngOnInit(): void {
    this.formularioRegistrarUsuario = this.formBuilder.group({
      nombre:[""],
      apellidoPaterno: [""],
      apellidoMaterno: [""],
      usuario:[""],
      contrasena:[""],
      rol:[""]
    });
    this.obtenerRoles();
  }

  obtenerRoles(){
    this.servicioAdmin.obtenerRoles().subscribe(
      respuesta=>{
        this.roles = respuesta;
      }
    );
  }

  registrarUsuario(){
    this.servicioAdmin.registrarUsuario(this.formularioRegistrarUsuario.value).subscribe(
      respuesta=>{
        alert("Se registró el usuario correctamente");
        this.formularioRegistrarUsuario.reset();
      },
      error=>{
        alert("Ocurrió un error al intentar registrar el usuario");
      }
    );
  }
}
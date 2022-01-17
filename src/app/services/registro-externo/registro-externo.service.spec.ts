import { TestBed } from '@angular/core/testing';

import { RegistroExternoService } from './registro-externo.service';

describe('RegistroExternoService', () => {
  let service: RegistroExternoService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(RegistroExternoService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});

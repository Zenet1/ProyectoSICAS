<?php
function validar_ldap($l, $p)
{
	$ldp_details = array(
		'sld' => 'IP',
		'uld' => 'USER@inet.uady.mx',
		'portld' => 'PUERTO',
		'pld'   => 'PASSWORD',
		'dn' => 'OU=INET,DC=inet,DC=uady,DC=mx'
	);

	$ds = ldap_connect($ldp_details['sld'], $ldp_details['portld']);  // Debe ser un servidor LDAP valido!

	if ($ds && $l != "" && $p != "") {
		//$l = escapeLdapFilter($l);
		//$p = escapeLdapFilter($p);
		ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
		$r = ldap_bind($ds,  $ldp_details['uld'],  $ldp_details['pld']);
		$filter = "(samaccountname=" . $l . ")";
		$result = ldap_search($ds,  $ldp_details['dn'],  $filter);
		if (ldap_count_entries($ds, $result)  > 0) {

			//denuevo bind
			$credencial = ldap_bind($ds,  $l . "@inet.uady.mx",  $p);
			if ($credencial) {
				//Usuario autentificado
				return 1;
			} else {
				return  0;
			}
		} else {
			return 0;
		}
		ldap_close($ds);
	} else {
		return 0;
	}
}

<?php 
return [ 
    'client_id' => 'AZmR0xg2iC3dG9U1q-5uVTD8kkl-HYKyIoiekh7kbE6HDYYjJ5YMb8ByHqyLTMFYIj8m_VuPe8LPTfGe',
	'secret' => 'EJxRMuxV-4VCTpD_diel2kKMhgmnIWn3oLcCIgtXLzCslokynPlLFQMf0ps8DmDKFfdAI6qGljhUBOCO',
    'settings' => array(
        'mode' => 'live',
        'http.ConnectionTimeOut' => 3000,
        'log.LogEnabled' => true,
        'log.FileName' => storage_path() . '/logs/paypal.log',
        'log.LogLevel' => 'FINE'
    ),
];
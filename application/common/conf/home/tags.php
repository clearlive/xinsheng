<?php 
/**
 
  
 
 

 

 
 */
return [
    'module_init'=> [
        'application\\home\\behavior\\InitConfig'
    ],
    'action_begin'=> [
        'application\\home\\behavior\\ListenProtectedUrl'
    ]
]
?>
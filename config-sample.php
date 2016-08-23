<?php

/* Database configuration */
define ('DATABASE_DSN', '' );
define ('DATABASE_USER', '');
define ('DATABASE_PASSWORD', '');

/* Set models available to which forms can be attached */
define ('SQLSERVER_MODELS', array('InteriorDesignBA', 
                'IST_BAS', 
                'DataAnalytics_BAS', 
                'AppliedAccounting_BAS',
                'HealthcareInformatics_BAS',
                'HealthcarePromotion_BAS',
                'HealthcareManagement_BAS',
                'RadiationImaging_BAS',
                'MolecularBiosciences_BAS',
                'Nursing_RN_BSN'
                ));

/* Set nonce values */
define ('NONCE_ACTION', '' );
define ('NONCE_FIELD', '' );

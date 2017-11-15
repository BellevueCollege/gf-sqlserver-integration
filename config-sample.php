<?php

/* Database configuration */
define ('DATABASE_DSN', '' );
define ('DATABASE_USER', '');
define ('DATABASE_PASSWORD', '');

/* Set models available to which forms can be attached */
define ('SQLSERVER_MODELS', 'AppliedAccounting_BAS,DataAnalytics_BAS,HealthcareInformatics_BAS,HealthcareManagement_BAS,HealthcarePromotion_BAS,'
        . 'InteriorDesign_BA,IST_BAS,MolecularBiosciences_BAS,Nursing_RN_BSN,RadiationImaging_BAS,ComputerScience_BS,TechPrepPayment,RadiationTherapyProgram_AA,'
        . 'HealthCareInformaticsCertificate,RadiologicTechnologyProgram_AA,HealthCareDataAnalyticsCertificate,DigitalMarketing_BAS,ASNConference,'
        . 'NursingAssistantCertifiedProgram, RAIS_DosimetryConcentration, NuclearMedicineProgram_AA');

/* Set default authorized payment status */
define ('DEFAULT_PAYMENT_STATUS', '');

/* Set nonce values */
define ('NONCE_ACTION', '' );
define ('NONCE_FIELD', '' );

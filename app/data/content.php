<?php
declare(strict_types=1);

return [

    'navigation' => [
        ['key' => 'home',      'label' => 'Home',                     'href' => 'index.php'],
        ['key' => 'about',     'label' => 'About Us',                 'href' => 'about.php'],
        ['key' => 'what-is',   'label' => 'What is a Clinical Trial', 'href' => 'what-is-a-clinical-trial.php'],
        ['key' => 'explore',   'label' => 'Explore Trials',           'href' => 'explore-trials.php'],
        ['key' => 'faq',       'label' => 'FAQ',                      'href' => 'faq.php'],
        ['key' => 'advocacy',  'label' => 'Advocacy Centre',          'href' => 'advocacy-centre.php'],
        ['key' => 'contact',   'label' => 'Contact Us',               'href' => 'contact.php'],
    ],

    'footerColumns' => [
        'Explore' => [
            ['label' => 'Explore Clinical Trials',  'href' => 'explore-trials.php'],
            ['label' => 'What is a Clinical Trial', 'href' => 'what-is-a-clinical-trial.php'],
            ['label' => 'Advocacy Centre',          'href' => 'advocacy-centre.php'],
            ['label' => 'FAQ',                      'href' => 'faq.php'],
        ],
        'Register' => [
            ['label' => 'Patient registration', 'href' => 'patient-registration.php'],
            ['label' => 'Doctor registration',  'href' => 'doctor-registration.php'],
        ],
        'OncoUday' => [
            ['label' => 'About Us',          'href' => 'about.php'],
            ['label' => 'Contact Us',        'href' => 'contact.php'],
            ['label' => 'Privacy Policy',    'href' => 'privacy-policy.php'],
            ['label' => 'Terms of Use',      'href' => 'terms-of-use.php'],
            ['label' => 'Medical Disclaimer', 'href' => 'medical-disclaimer.php'],
        ],
    ],

    'cancerTypes' => [
        ['slug' => 'breast',        'name' => 'Breast cancer',        'chip' => 'Breast',        'featured' => true],
        ['slug' => 'lung',          'name' => 'Lung cancer',          'chip' => 'Lung',          'featured' => true],
        ['slug' => 'head-and-neck', 'name' => 'Head and neck cancer', 'chip' => 'Head and neck', 'featured' => true],
        ['slug' => 'cervical',      'name' => 'Cervical cancer',      'chip' => 'Cervical',      'featured' => true],
        ['slug' => 'blood',         'name' => 'Blood cancers',        'chip' => 'Blood cancers', 'featured' => true],
        ['slug' => 'colorectal',    'name' => 'Colorectal cancer',    'chip' => 'Colorectal',    'featured' => true],
        ['slug' => 'ovarian',       'name' => 'Ovarian cancer',       'chip' => 'Ovarian',       'featured' => false],
        ['slug' => 'prostate',      'name' => 'Prostate cancer',      'chip' => 'Prostate',      'featured' => false],
        ['slug' => 'stomach',       'name' => 'Stomach cancer',       'chip' => 'Stomach',       'featured' => false],
        ['slug' => 'liver',         'name' => 'Liver cancer',         'chip' => 'Liver',         'featured' => false],
        ['slug' => 'brain',         'name' => 'Brain tumours',        'chip' => 'Brain',         'featured' => false],
        ['slug' => 'childhood',     'name' => 'Childhood cancers',    'chip' => 'Childhood',     'featured' => false],
        ['slug' => 'other',         'name' => 'Other cancers',        'chip' => 'Other',         'featured' => false],
    ],

    'cities' => [
        ['slug' => 'ahmedabad',          'name' => 'Ahmedabad'],
        ['slug' => 'bengaluru',          'name' => 'Bengaluru'],
        ['slug' => 'chandigarh',         'name' => 'Chandigarh'],
        ['slug' => 'chennai',            'name' => 'Chennai'],
        ['slug' => 'hyderabad',          'name' => 'Hyderabad'],
        ['slug' => 'jaipur',             'name' => 'Jaipur'],
        ['slug' => 'kochi',              'name' => 'Kochi'],
        ['slug' => 'kolkata',            'name' => 'Kolkata'],
        ['slug' => 'kozhikode',          'name' => 'Kozhikode'],
        ['slug' => 'lucknow',            'name' => 'Lucknow'],
        ['slug' => 'mumbai',             'name' => 'Mumbai'],
        ['slug' => 'new-delhi',          'name' => 'New Delhi'],
        ['slug' => 'pune',               'name' => 'Pune'],
        ['slug' => 'thiruvananthapuram', 'name' => 'Thiruvananthapuram'],
        ['slug' => 'vellore',            'name' => 'Vellore'],
    ],

    'specialties' => [
        ['slug' => 'medical-oncology',     'name' => 'Medical oncology'],
        ['slug' => 'radiation-oncology',   'name' => 'Radiation oncology'],
        ['slug' => 'surgical-oncology',    'name' => 'Surgical oncology'],
        ['slug' => 'haemato-oncology',     'name' => 'Haemato-oncology'],
        ['slug' => 'paediatric-oncology',  'name' => 'Paediatric oncology'],
        ['slug' => 'gynaec-oncology',      'name' => 'Gynaecologic oncology'],
        ['slug' => 'head-neck-oncology',   'name' => 'Head and neck oncology'],
        ['slug' => 'pathology',            'name' => 'Pathology'],
        ['slug' => 'general-medicine',     'name' => 'General medicine'],
        ['slug' => 'other',                'name' => 'Other specialty'],
    ],

    'faqCategories' => [
        ['slug' => 'patients', 'name' => 'Patients & caregivers'],
        ['slug' => 'doctors',  'name' => 'Doctors'],
        ['slug' => 'privacy',  'name' => 'Privacy'],
        ['slug' => 'listings', 'name' => 'About the listings'],
    ],

    'faqs' => [
        'patients' => [
            ['q' => 'Is OncoUday free for patients?', 'a' => 'Yes. Registering and receiving WhatsApp trial alerts is free for patients and caregivers.'],
            ['q' => 'Does registering enrol me in a trial?', 'a' => 'No. We only tell you about trials that match your city and cancer type. Joining a trial is a decision you make with your doctor and the trial team, after they explain the study and you give informed consent.'],
            ['q' => 'How do you decide which trials match me?', 'a' => 'Every new or updated trial is checked against the city and cancer type you registered with. When both match, we send you a short WhatsApp alert with a link to the trial details.'],
            ['q' => 'Can I register on behalf of a family member?', 'a' => 'Yes. Caregivers can register on behalf of a patient. For patients under 18, a parent or legal guardian must register and give consent on their behalf.'],
            ['q' => 'Do I need to download an app or create a password?', 'a' => 'No. You register once on this website and everything after that happens on WhatsApp, the app you already use. There is no password to remember.'],
            ['q' => 'How do I stop the alerts?', 'a' => 'Reply STOP to any OncoUday WhatsApp message and the alerts stop straight away. You can also ask us to delete your data at any time.'],
        ],
        'doctors' => [
            ['q' => 'Who can list a trial on OncoUday?', 'a' => 'Doctors and trial teams running a cancer clinical trial in India. Register as a doctor, choose “I run clinical trials”, then add the trial in a WhatsApp chat.'],
            ['q' => 'How long does it take to add a trial?', 'a' => 'About three minutes. With an NCT number it takes under a minute, because the details are filled in automatically from ClinicalTrials.gov and you only confirm them.'],
            ['q' => 'What is the weekly check?', 'a' => 'Once a week we send a one-tap WhatsApp message asking whether your trial is still active, closed or needs an update. The website changes instantly, so your listing stays accurate.'],
            ['q' => 'I don’t run trials. Can I still use OncoUday?', 'a' => 'Yes. Choose “I don’t run trials — I want to follow them” when you register. You will receive a short WhatsApp summary when a trial opens in your city or specialty.'],
            ['q' => 'Is there a fee for doctors?', 'a' => '[To be confirmed by OncoUday.]'],
        ],
        'privacy' => [
            ['q' => 'Who can see my details?', 'a' => 'Your details are never shown on the website. They are stored securely and used only to send you matching alerts.'],
            ['q' => 'Do the WhatsApp messages mention my diagnosis?', 'a' => 'No. Alerts are written in general terms and never mention your diagnosis in the message text.'],
            ['q' => 'Do you ask for my address?', 'a' => 'No. We only ask for your city, which is all we need to match you with nearby trials.'],
            ['q' => 'How do I delete my data?', 'a' => 'Contact our Grievance Officer through the Contact Us page and we will delete your data. You can also withdraw your consent at any time.'],
        ],
        'listings' => [
            ['q' => 'Where do the trial listings come from?', 'a' => 'Some trials are added by doctors on OncoUday. Others are imported every night from ClinicalTrials.gov, a service of the U.S. National Library of Medicine. Each listing is labelled with its source.'],
            ['q' => 'How often are listings updated?', 'a' => 'ClinicalTrials.gov listings are refreshed every night. Doctors confirm their own listings every week with a one-tap WhatsApp check.'],
            ['q' => 'Does OncoUday recommend any trial?', 'a' => 'No. OncoUday shares clinical trial information only. It is not medical advice and does not recommend any treatment. Always talk to your doctor before deciding to join a trial.'],
            ['q' => 'I found a mistake in a listing. What should I do?', 'a' => 'Please tell us through the Contact Us page with the trial ID. We will check it with the trial team.'],
        ],
    ],

    'rights' => [
        ['title' => 'Full information', 'text' => 'The trial team must explain the purpose, risks and benefits in a language you understand.'],
        ['title' => 'Written consent',  'text' => 'You join only after giving informed consent, and you can ask questions first.'],
        ['title' => 'Leave at any time', 'text' => 'You can withdraw whenever you choose, without losing your regular care.'],
        ['title' => 'Safety first',     'text' => 'An Ethics Committee oversees every trial for your safety and wellbeing.'],
        ['title' => 'Privacy',          'text' => 'Your medical and personal information must be kept confidential.'],
        ['title' => 'Care for injury',  'text' => 'Trial rules in India provide for medical care if you are harmed by the trial.'],
    ],

    'guides' => [
        ['tag' => 'Guide',          'title' => 'Is a clinical trial right for me?',      'icon' => 'signpost-split'],
        ['tag' => 'Checklist',      'title' => 'Questions to ask before you join',      'icon' => 'list-check'],
        ['tag' => 'Guide',          'title' => 'Understanding informed consent',        'icon' => 'file-earmark-text'],
        ['tag' => 'For caregivers', 'title' => 'Supporting a family member in a trial', 'icon' => 'people'],
        ['tag' => 'Guide',          'title' => 'Travel, costs and practical planning',  'icon' => 'geo-alt'],
        ['tag' => 'Directory',      'title' => 'Patient support groups near you',       'icon' => 'heart-pulse'],
    ],
];

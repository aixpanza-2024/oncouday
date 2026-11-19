<?php
declare(strict_types=1);

return [

    'navigation' => [
        ['key' => 'home',      'label' => 'Home',                     'href' => 'index.php'],
        ['key' => 'about',     'label' => 'About Us',                 'href' => 'about.php'],
        ['key' => 'explore',   'label' => 'Explore Trials',           'href' => 'explore-trials.php'],
        ['key' => 'what-is',   'label' => 'What is a Clinical Trial', 'href' => 'what-is-a-clinical-trial.php'],
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
            ['label' => 'Grievance Officer', 'href' => 'grievance-redressal.php'],
        ],
        'Legal' => [
            ['label' => 'Privacy Policy',       'href' => 'privacy-policy.php'],
            ['label' => 'Consent Notice',       'href' => 'consent-notice.php'],
            ['label' => 'Terms of Use',         'href' => 'terms-of-use.php'],
            ['label' => 'Terms for Doctors',    'href' => 'doctor-terms.php'],
            ['label' => 'Medical Disclaimer',   'href' => 'medical-disclaimer.php'],
            ['label' => 'Listing Policy',       'href' => 'listing-policy.php'],
            ['label' => 'Cookie Policy',        'href' => 'cookie-policy.php'],
            ['label' => 'Grievance Redressal',  'href' => 'grievance-redressal.php'],
        ],
    ],

    'legalPages' => [
        ['key' => 'privacy',        'label' => 'Privacy Policy',      'href' => 'privacy-policy.php'],
        ['key' => 'consent-notice', 'label' => 'Consent Notice',      'href' => 'consent-notice.php'],
        ['key' => 'terms',          'label' => 'Terms of Use',        'href' => 'terms-of-use.php'],
        ['key' => 'doctor-terms',   'label' => 'Terms for Doctors',   'href' => 'doctor-terms.php'],
        ['key' => 'disclaimer',     'label' => 'Medical Disclaimer',  'href' => 'medical-disclaimer.php'],
        ['key' => 'listing-policy', 'label' => 'Listing Policy',      'href' => 'listing-policy.php'],
        ['key' => 'cookies',        'label' => 'Cookie Policy',       'href' => 'cookie-policy.php'],
        ['key' => 'grievance',      'label' => 'Grievance Redressal', 'href' => 'grievance-redressal.php'],
    ],

    'cancerTypes' => [
        ['slug' => 'breast',        'name' => 'Breast cancer',        'chip' => 'Breast',        'featured' => true],
        ['slug' => 'lung',          'name' => 'Lung cancer',          'chip' => 'Lung',          'featured' => true],
        ['slug' => 'head-and-neck', 'name' => 'Head and neck cancer', 'chip' => 'Head and neck', 'featured' => true],
        ['slug' => 'cervical',      'name' => 'Cervical cancer',      'chip' => 'Cervical',      'featured' => true],
        ['slug' => 'blood',         'name' => 'Blood cancers',        'chip' => 'Blood cancers', 'featured' => true],
        ['slug' => 'colorectal',    'name' => 'Colorectal cancer',    'chip' => 'Colorectal',    'featured' => false],
        ['slug' => 'ovarian',       'name' => 'Ovarian cancer',       'chip' => 'Ovarian',       'featured' => false],
        ['slug' => 'prostate',      'name' => 'Prostate cancer',      'chip' => 'Prostate',      'featured' => false],
        ['slug' => 'stomach',       'name' => 'Stomach cancer',       'chip' => 'Stomach',       'featured' => false],
        ['slug' => 'liver',         'name' => 'Liver cancer',         'chip' => 'Liver',         'featured' => false],
        ['slug' => 'brain',         'name' => 'Brain tumours',        'chip' => 'Brain',         'featured' => false],
        ['slug' => 'childhood',     'name' => 'Childhood cancers',    'chip' => 'Childhood',     'featured' => false],
        ['slug' => 'other',         'name' => 'Other cancers',        'chip' => 'Other',         'featured' => false],
    ],

    'cities' => [
        ['slug' => 'ahmedabad', 'name' => 'Ahmedabad', 'state' => 'Gujarat'],
        ['slug' => 'bengaluru', 'name' => 'Bengaluru', 'state' => 'Karnataka'],
        ['slug' => 'chandigarh', 'name' => 'Chandigarh', 'state' => 'Chandigarh'],
        ['slug' => 'chennai', 'name' => 'Chennai', 'state' => 'Tamil Nadu'],
        ['slug' => 'hyderabad', 'name' => 'Hyderabad', 'state' => 'Telangana'],
        ['slug' => 'jaipur', 'name' => 'Jaipur', 'state' => 'Rajasthan'],
        ['slug' => 'kochi', 'name' => 'Kochi', 'state' => 'Kerala'],
        ['slug' => 'kolkata', 'name' => 'Kolkata', 'state' => 'West Bengal'],
        ['slug' => 'kozhikode', 'name' => 'Kozhikode', 'state' => 'Kerala'],
        ['slug' => 'lucknow', 'name' => 'Lucknow', 'state' => 'Uttar Pradesh'],
        ['slug' => 'mumbai', 'name' => 'Mumbai', 'state' => 'Maharashtra'],
        ['slug' => 'new-delhi', 'name' => 'New Delhi', 'state' => 'Delhi'],
        ['slug' => 'pune', 'name' => 'Pune', 'state' => 'Maharashtra'],
        ['slug' => 'thiruvananthapuram', 'name' => 'Thiruvananthapuram', 'state' => 'Kerala'],
        ['slug' => 'vellore', 'name' => 'Vellore', 'state' => 'Tamil Nadu'],
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
            ['q' => 'The trial I like is not yet recruiting. What should I do next?', 'a' => 'Register your name with OncoUday for that city and cancer type. We will notify you on WhatsApp as soon as the trial reaches its start date and begins recruiting, so you can talk to your doctor and the trial team about joining.'],
            ['q' => 'I find the form difficult. Can I register on WhatsApp instead?', 'a' => 'Yes. Tap “WhatsApp us” on any page and send “Hi”. Our WhatsApp assistant will ask a few simple questions and register you in the chat.'],
            ['q' => 'How do I stop the alerts?', 'a' => 'Reply STOP to any OncoUday WhatsApp message and the alerts stop straight away. You can also ask us to delete your data at any time.'],
        ],
        'doctors' => [
            ['q' => 'Who can list a trial on OncoUday?', 'a' => 'Doctors and trial teams running a cancer clinical trial in India. Register as a doctor, choose “I run clinical trials”, then add the trial in a WhatsApp chat.'],
            ['q' => 'How long does it take to add a trial?', 'a' => 'About three minutes. With an NCT number it takes under a minute, because the details are filled in automatically from ClinicalTrials.gov and you only confirm them.'],
            ['q' => 'What is the weekly check?', 'a' => 'Once a week we send a one-tap WhatsApp message asking whether your trial is still active, closed or needs an update. The website changes instantly, so your listing stays accurate.'],
            ['q' => 'I don’t run trials. Can I still use OncoUday?', 'a' => 'Yes. Choose “I don’t run trials — I want to follow them” when you register. You will receive a short WhatsApp summary when a trial opens in your city or specialty.'],
        ],
        'privacy' => [
            ['q' => 'Who can see my details?', 'a' => 'Your details are never shown on the website. They are stored securely and used only to send you matching alerts.'],
            ['q' => 'Do the WhatsApp messages mention my diagnosis?', 'a' => 'No. Alerts are written in general terms and never mention your diagnosis in the message text.'],
            ['q' => 'Do you ask for my address?', 'a' => 'No. We only ask for your city, which is all we need to match you with nearby trials.'],
            ['q' => 'How do I delete my data?', 'a' => 'Contact our Grievance Officer through the Contact Us page and we will delete your data. You can also withdraw your consent at any time.'],
        ],
        'listings' => [
            ['q' => 'Where do the trial listings come from?', 'a' => 'Some trials are added by doctors on OncoUday. Others are imported every night from ClinicalTrials.gov, a service of the U.S. National Library of Medicine. Each listing is labelled with its source.'],
            ['q' => 'How often are listings updated?', 'a' => 'Data is refreshed daily. Listings from ClinicalTrials.gov are updated every night, and doctors and trial teams send real-time updates straight from WhatsApp, with a one-tap check every week. Each listing shows the date it was last confirmed.'],
            ['q' => 'Does OncoUday recommend any trial?', 'a' => 'No. OncoUday shares clinical trial information only. It is not medical advice and does not recommend any treatment. Always talk to your doctor before deciding to join a trial.'],
            ['q' => 'I found a mistake in a listing. What should I do?', 'a' => 'Please tell us through the Contact Us page with the trial ID. We will check it with the trial team.'],
        ],
    ],

    'reviewed' => [
        'about'    => '2026-11-18',
        'what-is'  => '2026-11-18',
        'faq'      => '2026-11-18',
        'advocacy' => '2026-11-18',
        'explore'  => '2026-11-18',
    ],

    'team' => [
        'Founders' => [
            ['name' => 'Dr Uddiptya Goswami',       'role' => 'Founder', 'photo' => 'img/team/uddiptya.jpg'],
            ['name' => 'Dr Subhadarsini Mohapatra', 'role' => 'Co-Founder', 'photo' => 'img/team/subhadarsini.jpg'],
        ],
        'Medical advisor' => [
            ['name' => 'Dr Boben Thomas', 'role' => 'Medical Advisor', 'photo' => 'img/team/drboban.jpg'],
        ],
        'Contributors' => [
            ['name' => 'Dipanjan Narayan Chaudhary', 'role' => 'Senior Data & AI Engineer', 'photo' => 'img/team/dipanjan.jpg'],
            ['name' => 'Uddipan Goswami',            'role' => 'Data Engineer', 'photo' => 'img/team/uddipan.jpg'],
            ['name' => 'Sayantika Sengupta',         'role' => 'Data & AI Engineer', 'photo' => 'img/team/sayantika.jpg'],
            ['name' => 'Mohammed Hashim',            'role' => 'Freelancer', 'photo' => 'img/team/hashim.jpg'],
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

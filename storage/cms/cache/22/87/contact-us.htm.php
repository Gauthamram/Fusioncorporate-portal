<?php 
class Cms59ffb3c11c2e4511389390_1649635709Class extends \Cms\Classes\PageCode
{
public function onSend()
{
    // Collect input
$name = post('first_name').' '.post('last_name');
$email = post('email_address');
$msg = post('message');


 // Form Validation
    $validator = Validator::make(
        [
            'name' => $name,
            'email' => $email,
            'msg' => $msg,
        ],
        [
            'name' => 'required',
            'email' => 'required|email',
            'msg' => 'required',
        ]
    );
    
     if ($validator->fails())
    {
        $messages = $validator->messages();
        throw new ApplicationException($messages->first());
    }
    
    // Submit form
    $to = System\Models\MailSetting::get('sender_email');
    $params = compact('name','msg','email');
    $sendmail = Mail::sendTo($to, 'Fusion.contact.email', $params);
    $sendmail = Mail::sendTo($email, 'Fusion.contact.message.email', $params);
    if ($sendmail){
	    $this['level'] = 'success';
	    $this['msg'] = 'Your enquiry has been submitted';
    } else {
    	$this['level'] = 'danger';
	    $this['msg'] = 'Your enquiry has not been submitted, please try again. Thanks';
    }
}
}

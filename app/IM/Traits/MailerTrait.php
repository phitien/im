<?php

namespace App\IM\Traits;

use Mail;
use App\IM\Models\User;
use Html;
use App\IM\Config;

trait MailerTrait
{
	/**
	 *
	 * @param User $receiver        	
	 * @param string $template        	
	 * @param string $subject        	
	 */
	protected function mailTo(User $receiver, $template, $subject, $params = [], $sendAsHtml = true) {
		Mail::send ( "IM.email.$template", $params, function ($message) use ($receiver, $subject, $sendAsHtml) {
			$message->from ( 'info@www.ezsell.com', 'EZSell' );
			$message->to ( $receiver->email, $receiver->name )->subject ( $this->getMailSubject ( $subject ) );
			if (! $sendAsHtml) {
				// $message->setContentType ( 'text/html' );
				// $message->setBody ( Html::decode ( $message->getBody () ) );
			}
		} );
	}
	/**
	 *
	 * @param User $user        	
	 */
	protected function sendActivationEmail(User $user) {
		$this->mailTo ( $user, 'register', 'Welcome to EZSell', [ 
				'title' => 'Welcome to EZSell',
				'receiver' => $user,
				'url' => $user->baseUrl . '/activate/' . $user->generateActivationCode () 
		] );
	}
	/**
	 *
	 * @param User $user        	
	 */
	protected function resendActivationEmail(User $user) {
		$this->mailTo ( $user, 'register', 'Activation Re-send', [ 
				'title' => 'Welcome to EZSell',
				'receiver' => $user,
				'url' => $user->baseUrl . '/activate/' . $user->generateActivationCode () 
		] );
	}
	/**
	 *
	 * @param User $user        	
	 */
	protected function sendEmailChangedEmail(User $user, $newEmail) {
		$this->mailTo ( $user, 'email', 'Email changed', [ 
				'title' => 'Email changed',
				'receiver' => $user,
				'email' => $newEmail 
		] );
	}
	/**
	 *
	 * @param string $subject        	
	 * @return string
	 */
	protected function getMailSubject($subject) {
		return Config::MAIL_SUBJECT_PREFIX . $subject;
	}
}

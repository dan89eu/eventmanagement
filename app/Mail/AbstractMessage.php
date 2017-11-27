<?php
	/**
	 * Created by PhpStorm.
	 * User: danpetrescu
	 * Date: 27/11/2017
	 * Time: 21:56
	 */

	namespace App\Mail;

	use Illuminate\Bus\Queueable;
	use Illuminate\Mail\Mailable;
	use Illuminate\Queue\SerializesModels;
	use Illuminate\Contracts\Queue\ShouldQueue;
	/**
	 * Overrides…
	 */
	use Illuminate\Container\Container;
	use Illuminate\Contracts\Mail\Mailer as MailerContract;

	abstract class AbstractMessage extends Mailable implements ShouldQueue
	{
		use Queueable, SerializesModels;
		/**
		 * Describes additional headers.
		 *
		 * @var array
		 */
		protected $headers = [];

		public function __construct(array $headers = [])
		{
			$this->headers = $headers;
		}

		/**
		 * Send the message using the given mailer.
		 *
		 * @param \Illuminate\Contracts\Mail\Mailer $mailer
		 * @return void
		 */
		public function send(MailerContract $mailer)
		{
			Container::getInstance()->call([$this, 'build']);
			$mailer->send($this->buildView(), $this->buildViewData(),
				function ($message) {
					$this->buildFrom($message)
						->buildRecipients($message)
						->buildSubject($message)
						->buildAttachments($message)
						->attachCustomHeaders($message) // This is new!
						->runCallbacks($message);
				});
		}

		/**
		 * Add custom headers to the message.
		 *
		 * @param \Illuminate\Mail\Message $message
		 * @return $this
		 */
		protected function attachCustomHeaders($message)
		{
			$swift = $message->getSwiftMessage();
			$headers = $swift->getHeaders();
			foreach ($this->headers as $header => $value) {
				$headers->addTextHeader($header, $value);
			}
			return $this;
		}
	}
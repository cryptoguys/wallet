<?php namespace Owlgrin\Wallet\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

use Owlgrin\Wallet\Credit\CreditRepo;

/**
 * Command to generate the required migration
 */
class AddCreditsCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'wallet:add-credits';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'This command adds credits for user.';

	protected $creditRepo;

	/**
	 * Execute the console command.
	 *
	 * @return void
	 */

	public function __construct(CreditRepo $creditRepo)
	{
 		parent::__construct();
 		$this->creditRepo = $creditRepo;
	}

	public function fire()
	{
		$user       = $this->argument('user');
		$credit     = $this->argument('credit');
		$redemption = $this->argument('redemption');

		$this->creditRepo->add($user, $credit, $redemption);
	}

	protected function getArguments()
	{
		return array(
			array('user', InputArgument::REQUIRED, 'The user id of whose credit you want to add'),
			array('credit', InputArgument::REQUIRED, 'The amount(in cents) you want to add for you user'),
			array('redemption', InputArgument::REQUIRED, 'The number of redemptions')
		);
	}

}
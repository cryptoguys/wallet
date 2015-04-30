<?php namespace Owlgrin\Wallet;

use Illuminate\Support\ServiceProvider;
use Config;

class WalletServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('owlgrin/wallet');
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->registerCommands();
		$this->registerRepositories();

		$this->app->singleton('wallet', 'Owlgrin\Wallet\Wallet');
	}

	protected function registerCommands()
	{
		$this->app->bindShared('command.wallet.table', function($app)
		{
			return $app->make('Owlgrin\Wallet\Commands\WalletTableCommand');
		});

		$this->app->bindShared('command.wallet.add.credit', function($app)
		{
			return $app->make('Owlgrin\Wallet\Commands\AddCreditsCommand');
		});

		$this->app->bindShared('command.wallet.add.coupon', function($app)
		{
			return $app->make('Owlgrin\Wallet\Commands\AddCouponCommand');
		});

		$this->app->bindShared('command.wallet.add.coupon.for.user', function($app)
		{
			return $app->make('Owlgrin\Wallet\Commands\AddCouponForUserCommand');
		});

		$this->commands('command.wallet.table');
		$this->commands('command.wallet.add.credit');
		$this->commands('command.wallet.add.coupon');
		$this->commands('command.wallet.add.coupon.for.user');
	}

	protected function registerRepositories()
	{
		$this->app->bind('Owlgrin\Wallet\Coupon\CouponRepo', 'Owlgrin\Wallet\Coupon\DbCouponRepo');
		$this->app->bind('Owlgrin\Wallet\Transaction\TransactionRepo', 'Owlgrin\Wallet\Transaction\DbTransactionRepo');
		$this->app->bind('Owlgrin\Wallet\Wallet\WalletRepo', 'Owlgrin\Wallet\Wallet\DbWalletRepo');

		$this->app->bind('Owlgrin\Wallet\Transaction\RedemptionTransactionMaker', function($app)
		{
		   return app($app['config']['wallet::transactions.redemption']);
		});

		$this->app->bind('Owlgrin\Wallet\Transaction\AmountTransactionMaker', function($app)
		{
		   return app($app['config']['wallet::transactions.amount']);
		});

	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}

}

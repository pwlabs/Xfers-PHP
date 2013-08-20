<?php

/**
 * Possible transaction statuses.
 *
 * Documentation
 * https://docs.google.com/a/paywhere.com/document/d/1ZtAx21r2BJuApIqlsMfS8JELUAiKVEFoDOggZXNNDxI/
 */
class TransactionStatus {
	/*
	 * The current transaction is still unclaimed. This usually happens when an
	 * buyer has checkout an item but has yet to login to Xfers to "claim" the
	 * transaction.
	 */

	const UNCLAIMED = 'unclaimed';

	/*
	 * Buyer has success login to Xfers and "claimed" the transaction. But
	 * he/she has not accepted the transaction.
	 */
	const PENDING = 'pending';

	/*
	 * Buyer has accepted the transaction via Xfers.
	 */
	const ACCEPTED = 'accepted';

	/*
	 * Buyer has sufficient funds in his/her account and the transaction has
	 * been processed after he/she has accepted it. This status will
	 * automatically changed to "withheld" in 5 days.
	 */
	const PAID = 'paid';

	/*
	 * The merchant has shipped the good. This can be trigger via Xfers console
	 * or via APIs call by the merchant.
	 */
	const SHIPPED = 'shipped';

	/*
	 * This is a system set duration where buyer will be able to raise an
	 * transaction dispute/seek refund. This currently default to 10 days and
	 * will starts immediately after transaction has been set to "shipped".
	 */
	const WITHHELD = 'withheld';

	/*
	 * Transaction has successfully been completed and buyer did not raise a
	 * dispute within the "withheld" period. The funds are now available for
	 * withdrawal by the merchant.
	 */
	const COMPLETED = 'completed';

	/*
	 * This transaction has been cancelled. This can be trigger via Xfers
	 * console or APIs Call by both buyer and merchant. Note: This can only be
	 * done before the transaction reach "paid" status.
	 */
	const CANCELLED = 'cancelled';

	/*
	 * This transaction has expired. This usually happens when a buyer did not
	 * "claim" a transaction or transfer sufficient funds to Xfers after
	 * accepting a transaction. The default time period for this is currently 4
	 * hrs.
	 */
	const EXPIRED = 'expired';

	/*
	 * Buyer has raised a dispute on a transaction. Merchant needs to reach out
	 * to the buyer and resolve this issue. The funds will be freezed (i.e
	 * transaction will not transit to completed status) until this is resolved.
	 */
	const DISPUTE = 'dispute';

	/*
	 * Merchant has refunded the transaction. This can be done via Xfers console
	 * or via APIs call by the merchant.
	 * Note: This can only be done after the transaction reach "paid" status and
	 * before it become "completed".
	 */
	const REFUNDED = 'refunded';

}
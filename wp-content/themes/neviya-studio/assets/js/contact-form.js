/**
 * Contact form: AJAX submit with Hebrew success/error messaging.
 */
( function () {
	'use strict';

	function ready( fn ) {
		if ( document.readyState !== 'loading' ) {
			fn();
		} else {
			document.addEventListener( 'DOMContentLoaded', fn );
		}
	}

	ready( function () {
		var form = document.getElementById( 'neviya-contact-form' );
		if ( ! form || typeof NeviyaContact === 'undefined' ) {
			return;
		}

		var status = form.querySelector( '.neviya-contact-form__status' );
		var submitBtn = form.querySelector( '.neviya-btn--submit' );

		function setStatus( message, state ) {
			if ( ! status ) {
				return;
			}
			status.textContent = message;
			status.setAttribute( 'data-state', state || '' );
		}

		form.addEventListener( 'submit', function ( event ) {
			event.preventDefault();

			var name = form.querySelector( '[name="name"]' ).value.trim();
			var contact = form.querySelector( '[name="contact"]' ).value.trim();
			var message = form.querySelector( '[name="message"]' ).value.trim();
			var consent = form.querySelector( '[name="consent"]' ).checked;

			if ( ! name || ! contact || ! message || ! consent ) {
				setStatus( NeviyaContact.i18n.invalid, 'error' );
				return;
			}

			var data = new FormData( form );
			data.append( 'action', 'neviya_contact_form' );
			data.append( 'nonce', NeviyaContact.nonce );

			if ( submitBtn ) {
				submitBtn.disabled = true;
			}
			setStatus( NeviyaContact.i18n.sending, '' );

			fetch( NeviyaContact.ajaxUrl, {
				method: 'POST',
				credentials: 'same-origin',
				body: data,
			} )
				.then( function ( response ) {
					return response.json();
				} )
				.then( function ( json ) {
					if ( json && json.success ) {
						setStatus( ( json.data && json.data.message ) || NeviyaContact.i18n.success, 'success' );
						form.reset();
					} else {
						setStatus( ( json && json.data && json.data.message ) || NeviyaContact.i18n.error, 'error' );
					}
				} )
				.catch( function () {
					setStatus( NeviyaContact.i18n.error, 'error' );
				} )
				.finally( function () {
					if ( submitBtn ) {
						submitBtn.disabled = false;
					}
				} );
		} );
	} );
} )();

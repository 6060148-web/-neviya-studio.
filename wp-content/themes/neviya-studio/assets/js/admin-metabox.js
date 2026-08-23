/**
 * wp-admin only: media uploader for cover/gallery/sketch/color image
 * fields and the colour picker, on the neviya_project editor screen.
 */
jQuery( function ( $ ) {
	'use strict';

	$( '.neviya-color-field' ).wpColorPicker();

	$( '.neviya-image-field' ).each( function () {
		var $field = $( this );
		var $input = $field.find( 'input[type="hidden"]' );
		var $preview = $field.find( '.neviya-image-field__preview' );
		var $selectBtn = $field.find( '.neviya-image-field__select' );
		var $removeBtn = $field.find( '.neviya-image-field__remove' );
		var frame;

		$selectBtn.on( 'click', function ( e ) {
			e.preventDefault();
			if ( frame ) {
				frame.open();
				return;
			}
			frame = wp.media( { title: neviyaAdminMetabox.chooseImage, multiple: false, library: { type: 'image' } } );
			frame.on( 'select', function () {
				var attachment = frame.state().get( 'selection' ).first().toJSON();
				var url = ( attachment.sizes && attachment.sizes.medium ) ? attachment.sizes.medium.url : attachment.url;
				$input.val( attachment.id );
				$preview.html( $( '<img>' ).attr( 'src', url ).css( { maxWidth: 160, height: 'auto', display: 'block' } ) );
				$removeBtn.show();
			} );
			frame.open();
		} );

		$removeBtn.on( 'click', function ( e ) {
			e.preventDefault();
			$input.val( '' );
			$preview.empty();
			$( this ).hide();
		} );
	} );

	$( '.neviya-gallery-field' ).each( function () {
		var $field = $( this );
		var $input = $field.find( 'input[type="hidden"]' );
		var $list = $field.find( '.neviya-gallery-field__list' );
		var $selectBtn = $field.find( '.neviya-gallery-field__select' );

		function getIds() {
			return ( $input.val() || '' ).split( ',' ).filter( Boolean );
		}
		function setIds( ids ) {
			$input.val( ids.join( ',' ) );
		}

		$selectBtn.on( 'click', function ( e ) {
			e.preventDefault();
			var frame = wp.media( { title: neviyaAdminMetabox.addToGallery, multiple: true, library: { type: 'image' } } );
			frame.on( 'select', function () {
				var ids = getIds();
				frame.state().get( 'selection' ).each( function ( attachment ) {
					attachment = attachment.toJSON();
					var idStr = String( attachment.id );
					if ( ids.indexOf( idStr ) !== -1 ) {
						return;
					}
					ids.push( idStr );
					var thumb = ( attachment.sizes && attachment.sizes.thumbnail ) ? attachment.sizes.thumbnail.url : attachment.url;
					var $li = $( '<li>' ).attr( 'data-id', idStr );
					$li.append( $( '<img>' ).attr( 'src', thumb ).attr( 'alt', '' ) );
					$li.append( $( '<button type="button" class="neviya-gallery-field__remove-item">&times;</button>' ).attr( 'aria-label', neviyaAdminMetabox.removeImage ) );
					$list.append( $li );
				} );
				setIds( ids );
			} );
			frame.open();
		} );

		$list.on( 'click', '.neviya-gallery-field__remove-item', function ( e ) {
			e.preventDefault();
			var $li = $( this ).closest( 'li' );
			var id = String( $li.data( 'id' ) );
			setIds( getIds().filter( function ( value ) {
				return value !== id;
			} ) );
			$li.remove();
		} );
	} );
} );

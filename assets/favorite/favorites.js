( function( $ ) {
	'use strict';

	class ButtonActions {
		constructor( className, ignoreClassName = null ) {
			this.className = className;
			this.ignoreClassName = ignoreClassName;
			this.buttons = null;
			this.data = null;
			this.action = null;
			this.id = null;
			this.icon = null;
			this.handleClick();
		}
		handleClick = () => {
			
			document.addEventListener( 'click', event => {				
				const button = event.target;
				if (
					!button.classList.contains( this.className )
					|| ( this.ignoreClassName && button.classList.contains( this.ignoreClassName ) )
				) {
					return;
				}
				
				

				if ( CTRLListings.nonLoggedIn ) {
					alert( CTRLListings.loginAlert );
					return;
				}

				

				this.id = button.dataset.id;
				this.icon = button.dataset.icon;
				this.buttons = document.querySelectorAll( `.${ this.className }[data-id="${ this.id }"]` );

				this.setData();
				this.beforeFetching()
					.then( this.fetch )
					.then( this.afterFetching );
			} );
		};
		setData = () => {
			this.data = new FormData();
			this.data.append( 'action', this.action );
			this.data.append( 'id', this.id );
			this.data.append( 'icon', this.icon );
			this.data.append( '_wpnonce', this.nonce );
		};
		beforeFetching = () => new Promise( ( resolve, reject ) => {
			this.buttons.forEach( button => button.classList.add( 'ctrl-listings-loading' ) );
			resolve();
		} );
		fetch = () => fetch( CTRLListings.ajaxUrl, {
			method: "POST",
			credentials: 'same-origin',
			body: this.data,
		} );
		handleShowCount = ( button, count ) => {
			let spanCount = button.querySelector( '.mbfp-count' );

			if ( null !== spanCount ) {
				spanCount.innerHTML = count;
			}
		};
		
	}

	class ButtonAdd extends ButtonActions {
		constructor( className, ignoreClassName ) {
			super( className, ignoreClassName );
			this.action = 'ctrl_listing_favorite_add';
			this.nonce = CTRLListings.addNonce;
		}

		afterFetching = response => response.json().then( ( res ) => {
			this.buttons.forEach( button => {
				button.classList.add( 'ctrl-listing-favorite-added' );

				let text = button.querySelector( '.favorite-text-detail' );
				if ( null !== text ) {
					text.innerHTML = button.dataset.added;
				}
				button.querySelector( '.svg-icon' ).outerHTML = res.data.icon;
				this.handleShowCount( button, res.data.count );

				// Returns a Bootstrap tooltip instance
				const tooltip = bootstrap.Tooltip.getInstance(button) 
				tooltip.setContent({ '.tooltip-inner': res.data.msg });
			} );
		} );
	}

	class ButtonDelete extends ButtonActions {
		constructor( className, ignoreClassName ) {
			super( className, ignoreClassName );
			this.action = 'ctrl_listing_favorite_delete';
			this.nonce = CTRLListings.deleteNonce;
		}

		afterFetching = response => response.json().then( ( res ) => {
			this.buttons.forEach( button => {
				button.classList.remove( 'ctrl-listing-favorite-added' );

				let text = button.querySelector( '.favorite-text-detail' );
				if ( null !== text ) {
					text.innerHTML = button.dataset.add;
				}
				button.querySelector( '.svg-icon' ).outerHTML = res.data.icon;				
				this.handleShowCount( button, res.data.count );

				// Returns a Bootstrap tooltip instance
				const tooltip = bootstrap.Tooltip.getInstance(button) 
				tooltip.setContent({ '.tooltip-inner': res.data.msg });

			} );
		} );
	}

	class ButtonDeleteFromTable extends ButtonActions {
		constructor( buttons ) {
			super( buttons );
			this.action = 'ctrl_listing_favorite_delete';
			this.nonce = CTRLListings.deleteNonce;
			this.table = document.querySelector( '.ctrl-listings-favorite-posts' );
		}
		beforeFetching = () => new Promise( ( resolve, reject ) => {
			const confirmDelete = confirm( CTRLListings.confirmDelete );
			if ( confirmDelete ) {
				this.table.classList.add( 'ctrl-listings-loading' );
				resolve();
			} else {
				reject();
			}
		} );
		afterFetching = response => response.json().then( ( res ) => {
			this.table.classList.remove( 'ctrl-listings-loading' );
			this.table.querySelector( `tr[data-id="${ this.id }"]` ).remove();

			if ( res.data.empty_notice ) {
				const noPostNotice = document.createElement( 'div' );
				noPostNotice.classList.add( 'ctrl-listings-favorite-notice' );
				noPostNotice.textContent = res.data.empty_notice;
				this.table.after( noPostNotice );
				this.table.remove();
			}
		} );
	}

	new ButtonAdd( 'ctrl-listing-favorite', 'ctrl-listing-favorite-added' );
	new ButtonDelete( 'ctrl-listing-favorite-added' );
	new ButtonDeleteFromTable( 'ctrl-listing-favorite-table-delete' );
}( jQuery ) );
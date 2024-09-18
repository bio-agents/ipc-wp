/**
 * @output wp-includes/js/customize-views.js
 */

(function( $, wp, _ ) {

	if ( ! wp || ! wp.customize ) { return; }
	var api = wp.customize;

	/**
	 * wp.customize.HeaderAgent.CurrentView
	 *
	 * Displays the currently selected header image, or a placeholder in lack
	 * thereof.
	 *
	 * Instantiate with model wp.customize.HeaderAgent.currentHeader.
	 *
	 * @memberOf wp.customize.HeaderAgent
	 * @alias wp.customize.HeaderAgent.CurrentView
	 *
	 * @constructor
	 * @augments wp.Backbone.View
	 */
	api.HeaderAgent.CurrentView = wp.Backbone.View.extend(/** @lends wp.customize.HeaderAgent.CurrentView.prototype */{
		template: wp.template('header-current'),

		initialize: function() {
			this.listenTo(this.model, 'change', this.render);
			this.render();
		},

		render: function() {
			this.$el.html(this.template(this.model.toJSON()));
			this.setButtons();
			return this;
		},

		setButtons: function() {
			var elements = $('#customize-control-header_image .actions .remove');
			if (this.model.get('choice')) {
				elements.show();
			} else {
				elements.hide();
			}
		}
	});


	/**
	 * wp.customize.HeaderAgent.ChoiceView
	 *
	 * Represents a choosable header image, be it user-uploaded,
	 * theme-suggested or a special Randomize choice.
	 *
	 * Takes a wp.customize.HeaderAgent.ImageModel.
	 *
	 * Manually changes model wp.customize.HeaderAgent.currentHeader via the
	 * `select` method.
	 *
	 * @memberOf wp.customize.HeaderAgent
	 * @alias wp.customize.HeaderAgent.ChoiceView
	 *
	 * @constructor
	 * @augments wp.Backbone.View
	 */
	api.HeaderAgent.ChoiceView = wp.Backbone.View.extend(/** @lends wp.customize.HeaderAgent.ChoiceView.prototype */{
		template: wp.template('header-choice'),

		className: 'header-view',

		events: {
			'click .choice,.random': 'select',
			'click .close': 'removeImage'
		},

		initialize: function() {
			var properties = [
				this.model.get('header').url,
				this.model.get('choice')
			];

			this.listenTo(this.model, 'change:selected', this.toggleSelected);

			if (_.contains(properties, api.get().header_image)) {
				api.HeaderAgent.currentHeader.set(this.extendedModel());
			}
		},

		render: function() {
			this.$el.html(this.template(this.extendedModel()));

			this.toggleSelected();
			return this;
		},

		toggleSelected: function() {
			this.$el.toggleClass('selected', this.model.get('selected'));
		},

		extendedModel: function() {
			var c = this.model.get('collection');
			return _.extend(this.model.toJSON(), {
				type: c.type
			});
		},

		select: function() {
			this.preventJump();
			this.model.save();
			api.HeaderAgent.currentHeader.set(this.extendedModel());
		},

		preventJump: function() {
			var container = $('.wp-full-overlay-sidebar-content'),
				scroll = container.scrollTop();

			_.defer(function() {
				container.scrollTop(scroll);
			});
		},

		removeImage: function(e) {
			e.stopPropagation();
			this.model.destroy();
			this.remove();
		}
	});


	/**
	 * wp.customize.HeaderAgent.ChoiceListView
	 *
	 * A container for ChoiceViews. These choices should be of one same type:
	 * user-uploaded headers or theme-defined ones.
	 *
	 * Takes a wp.customize.HeaderAgent.ChoiceList.
	 *
	 * @memberOf wp.customize.HeaderAgent
	 * @alias wp.customize.HeaderAgent.ChoiceListView
	 *
	 * @constructor
	 * @augments wp.Backbone.View
	 */
	api.HeaderAgent.ChoiceListView = wp.Backbone.View.extend(/** @lends wp.customize.HeaderAgent.ChoiceListView.prototype */{
		initialize: function() {
			this.listenTo(this.collection, 'add', this.addOne);
			this.listenTo(this.collection, 'remove', this.render);
			this.listenTo(this.collection, 'sort', this.render);
			this.listenTo(this.collection, 'change', this.toggleList);
			this.render();
		},

		render: function() {
			this.$el.empty();
			this.collection.each(this.addOne, this);
			this.toggleList();
		},

		addOne: function(choice) {
			var view;
			choice.set({ collection: this.collection });
			view = new api.HeaderAgent.ChoiceView({ model: choice });
			this.$el.append(view.render().el);
		},

		toggleList: function() {
			var title = this.$el.parents().prev('.customize-control-title'),
				randomButton = this.$el.find('.random').parent();
			if (this.collection.shouldHideTitle()) {
				title.add(randomButton).hide();
			} else {
				title.add(randomButton).show();
			}
		}
	});


	/**
	 * wp.customize.HeaderAgent.CombinedList
	 *
	 * Aggregates wp.customize.HeaderAgent.ChoiceList collections (or any
	 * Backbone object, really) and acts as a bus to feed them events.
	 *
	 * @memberOf wp.customize.HeaderAgent
	 * @alias wp.customize.HeaderAgent.CombinedList
	 *
	 * @constructor
	 * @augments wp.Backbone.View
	 */
	api.HeaderAgent.CombinedList = wp.Backbone.View.extend(/** @lends wp.customize.HeaderAgent.CombinedList.prototype */{
		initialize: function(collections) {
			this.collections = collections;
			this.on('all', this.propagate, this);
		},
		propagate: function(event, arg) {
			_.each(this.collections, function(collection) {
				collection.trigger(event, arg);
			});
		}
	});

})( jQuery, window.wp, _ );

/**
 * @class AppManager
 */
/**
 * @variable appManager
 */
module.exports = window.appManager = new Store();
//
Object.assign(appManager, {
	tokenKey : function(val) {
		if (val != null)
			this.set('tokenKey', val);
		return this.get('tokenKey');
	},
	currentUrl : function(val) {
		if (val != null)
			this.set('currentUrl', val);
		return this.get('currentUrl');
	},
	linkDirectly : function(val) {
		if (val != null)
			this.set('linkDirectly', val);
		return this.get('linkDirectly');
	},
	usecode : function(val) {
		if (val != null)
			this.set('usecode', val);
		return this.get('usecode');
	},
	socketId : function(val) {
		if (val != null)
			this.set('socketId', val);
		return this.get('socketId');
	},
	clientKey : function() {
		return this.user().id + '+' + location.hostname;
	},
	showLeft : function(val) {
		if (val != null)
			this.set('showLeft', parseInt(val));
		return this.get('showLeft', 0);
	},
	showRight : function(val) {
		if (val != null)
			this.set('showRight', parseInt(val));
		return this.get('showRight', 0);
	},
	showBanner : function(val) {
		if (val != null)
			this.set('showBanner', val);
		return this.get('showBanner');
	},
	mode : function(val) {
		if (val != null)
			this.set('mode', parseInt(val));
		return this.get('mode');
	},
	appMessage : function(val) {
		if (val != null)
			this.set('appMessage', val);
		return this.get('appMessage');
	},
	location : function(val) {
		if (val != null)
			this.set('location', val);
		return this.get('location');
	},
	cats : function(val) {
		if (val != null)
			this.set('cats', val);
		return this.get('cats');
	},
	isGuest : function(val) {
		if (val != null)
			this.set('isGuest', val);
		return this.get('isGuest');
	},
	isLogged : function() {
		if (this.user() && this.user().id && this.user().id > 0) {
			return this.user();
		}
		return false;
	},
	user : function(val) {
		if (val != null) {
			this.set('user', val);
		}
		return JSON.parse($.base64.decode(this.get('user')));
	},
	socketUri : function(val) {
		if (val != null)
			this.set('socketUri', val);
		return this.get('socketUri');
	},
	type : function(val) {
		if (val != null) {
			this.set('type', val);
		}
		return this.get('type', 'HomePage');
	},
	data : function(val) {
		if (val != null)
			this.set('data', val);
		return this.get('data');
	},
	paginate : function(val) {
		if (val != null)
			this.set('paginate', val);
		return this.get('paginate');
	},
	item : function(id, val) {
		if (this.type() != 'CatItems' && this.type() != 'UserItems') {
			return this.data(val);
		} else {
			var paginate = this.paginate();
			for (var i = 0; i < paginate.data.length; i++) {
				if (id == paginate.data[i].id) {
					if (val != null)
						paginate.data[i] = val;
					return paginate.data[i];
				}
			}
		}
		return null;
	},
	configurations : function(configurations) {
		for ( var k in configurations) {
			try {
				this[k](configurations[k]);
			} catch (e) {
				this.set(k, configurations[k]);
			}
		}
		document.title = this.get('title');
		Dispatcher.dispatch(new Action(AppEvents.CONFIGURATIONS_UPDATE,
				configurations));
	}
});

/**
 * ItemSummary defination
 */
var ItemSummary = React.createClass({
	render : function() {
		const className = 'item-summary ' + (this.props.className?this.props.className:'');
		const item = this.props.item;
		const showLink = this.props.hasOwnProperty('showLink') ? this.props.showLink : true;
		const href = showLink ? '/item/' + item.id : 'javascript:void(0);';
		var posted_at = <div className='item-created'>
							<a><span className='label'>Posted:</span><span className='datetimeformat'>{item.created_at}</span></a>
						</div>;
						
		var created = new Date(item.created_at);
		var updated = new Date(item.updated_at);
		if (+updated !== +created) {
			posted_at = <div className='item-date item-updated'>
							<a><span className='label'>Edited:</span><span className='datetimeformat'>{item.updated_at}</span></a>
						</div>;
		}
		var expired_at = '';
		if (item.deleted_at) {
			expired_at = <div className='item-date item-expired'>
							<a><span className='label'>Expire:</span><span className='datetimeformat'>{item.deleted_at}</span></a>
						</div>;
		}
		var prices = this.props.hasOwnProperty('prices') ? this.props.prices.split(',') : ['original','sale','now'];
		var price_list = 
		<div className='item-prices'>{prices.map(function (o,i) {
			var pclassName = 'item-price item-' + o + 'price';
			var pvalue = item[o+'price'];
			return (
				<div className={pclassName} key={i}>
					<span className='currency-sign'>{currentLocation.currency}</span>
					<span className='currency-value'>{pvalue}</span> 
					<span className='label'>{o[0].toUpperCase() + o.slice(1)}</span>
				</div>
			);
		})}
		</div>;
		return (
			<div className={className}>
				<div className='item-title'>
					<a href={href}><span>{item.title}</span></a>
				</div>
				{posted_at}
				{expired_at}
				<div className={item.is_new ? 'new' : 'used'}>{item.is_new ? 'New' : 'Used'}</div>
				{price_list}
			</div>
		);
	}
});

export default ItemSummary;

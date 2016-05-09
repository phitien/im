import Input from './../components/form/input.jsx';
import Button from './../components/form/button.jsx';
import FormView from './../components/formview.jsx';
//
$( document ).ready(function() {
	ReactDOM.render(React.createElement(FormView, {
		className : 'EzsellView AccountView',
		formrender() { 
			return (
				<Formsy.Form className='EzsellForm' method='post' action='/'  
				onValidSubmit={this.submit}  onValid={this.enableButton} onInvalid={this.disableButton}>
					<input type='hidden' name='redirect' value={location.href} />
				</Formsy.Form>
			); 
		}
	}), document.getElementById('container'));
});

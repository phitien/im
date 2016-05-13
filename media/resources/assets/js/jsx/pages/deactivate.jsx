$( document ).ready(function() {
	ReactDOM.render(React.createElement(FormView, {
		formrender() { 
			return (
				<FormView.Form className='form row' method='post' action='/deactivate' autocomplete='off' onkeypress='return event.keyCode != 13;'
				onValidSubmit={this.submit}  onValid={this.enableButton} onInvalid={this.disableButton}>
					<div className="col-xs-12 col-sm-6 col-md-5 center-block">
						<FormView.Input type='password' required name='current_password' title='Password' 
							validationError='Password is required' />
						<FormView.Input type='submit' name='btn-submit' disabled={!this.state.canSubmit} value='Deactivate' className='center-block' />
					</div>
				</FormView.Form>
			); 
		}
	}), document.getElementById(contentDivId));
});
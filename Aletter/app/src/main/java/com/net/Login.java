package com.net;

import org.json.JSONException;
import org.json.JSONObject;


public class Login {

	public Login(String phone_md5,String code,final SuccessCallback successCallback,final FailCallback failCallback) {
		new NetConnection("http://***/smartprotecter/sm/login_m.php", HttpMethod.POST, new NetConnection.SuccessCallback() {
			
			@Override
			public void onSuccess(String result) {
				try {
					JSONObject obj = new JSONObject(result);
					
					successCallback.onSuccess();

					
				} catch (JSONException e) {
					e.printStackTrace();

				}
			}
		}, new NetConnection.FailCallback() {
			
			@Override
			public void onFail() {
				if (failCallback!=null) {
					failCallback.onFail();
				}
			}
		});
	}
	
	public static interface SuccessCallback{
		void onSuccess();
	}
	
	public static interface FailCallback{
		void onFail();
	}
}

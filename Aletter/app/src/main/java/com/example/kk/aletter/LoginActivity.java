package com.example.kk.aletter;

import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.content.Intent;
import com.net.Login;

public class LoginActivity extends AppCompatActivity {

    @Override
    protected void onCreate(final Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.fragment_login);


        Button btn = (Button)findViewById(R.id.frag_login_btn_login);
        btn.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {

                new Login("xxx", "xxx", new Login.SuccessCallback() {
                    @Override
                    public void onSuccess() {
                        Intent i = new Intent(LoginActivity.this,MainScreen.class);
                        startActivity(i);
                    }
                }, new Login.FailCallback() {
                    @Override
                    public void onFail() {

                    }
                });



            }
        });
    }
}

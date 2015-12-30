/*
 * ViewReport.java
 *
 * Created on July 19, 2006, 12:07 AM
 */

package coshms.servlets.emergency;

import coshms.util.BasicFunction;
import java.io.*;

import javax.servlet.*;
import javax.servlet.http.*;

/**
 *
 * @author Asif
 * @version
 */
public class ViewReport extends HttpServlet {
    protected void processRequest(HttpServletRequest request, HttpServletResponse response)
    throws ServletException, IOException {
        response.setContentType("text/html;charset=UTF-8");
        PrintWriter out = response.getWriter();
        
        java.sql.Date fromDate= new BasicFunction().strToDate(request.getParameter("fromDate"));
        java.sql.Date toDate= new BasicFunction().strToDate(request.getParameter("toDate"));

        RequestDispatcher dispatcher = null;
        request.setAttribute("fromDate",fromDate);
        request.setAttribute("toDate",toDate);
        
        switch(Integer.parseInt(request.getParameter("id"))){
            case 1:
                dispatcher = request.getRequestDispatcher("RegPatients.jsp");
                break;
            case 2:
                dispatcher = request.getRequestDispatcher("RegFromEachCity.jsp");
                break;
            case 3:
                dispatcher = request.getRequestDispatcher("EncPatients.jsp");
                break;
            case 4:
                dispatcher = request.getRequestDispatcher("MlcCases.jsp");
                break;
             case 5:
                dispatcher = request.getRequestDispatcher("DiseaseDiag.jsp");
                break;
             case 6:
                dispatcher = request.getRequestDispatcher("DiseasesDiag.jsp");
                break;
            default:
                ;
        }        
        dispatcher.forward(request,response);
        
        /* TODO output your page here
         out.println("<html>");
        out.println("<head>");
        out.println("<title>Servlet ViewReport</title>");
        out.println("</head>");
        out.println("<body>");
        out.println("<h1>Servlet ViewReport at " + request.getContextPath () + "</h1>");
        out.println("</body>");
        out.println("</html>");
         */
        out.close();
    }
    
    // <editor-fold defaultstate="collapsed" desc="HttpServlet methods. Click on the + sign on the left to edit the code.">
    /** Handles the HTTP <code>GET</code> method.
     * @param request servlet request
     * @param response servlet response
     */
    protected void doGet(HttpServletRequest request, HttpServletResponse response)
    throws ServletException, IOException {
        processRequest(request, response);
    }
    
    /** Handles the HTTP <code>POST</code> method.
     * @param request servlet request
     * @param response servlet response
     */
    protected void doPost(HttpServletRequest request, HttpServletResponse response)
    throws ServletException, IOException {
        processRequest(request, response);
    }
    
    /** Returns a short description of the servlet.
     */
    public String getServletInfo() {
        return "Short description";
    }
    // </editor-fold>
}

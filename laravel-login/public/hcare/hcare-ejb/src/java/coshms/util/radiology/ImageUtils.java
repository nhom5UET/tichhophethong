/*
 * ImageUtils.java
 *
 * Created on June 6, 2006, 9:59 PM
 *
 * To change this template, choose Tools | Template Manager
 * and open the template in the editor.
 */

package coshms.util.radiology;

import java.io.*;
import java.awt.*;
import java.awt.image.*;
import javax.imageio.*;
import javax.imageio.stream.*;
import java.util.Iterator;

/**
 *
 * @author Administrator
 */
public class ImageUtils {
    
    /** Creates a new instance of ImageUtils */
    public ImageUtils() {
    }
    public static void constrain( String srcFilename, String destFilename, int boxSize )
    {
        try
        {
            FileInputStream fis = new FileInputStream( srcFilename );
            MemoryCacheImageOutputStream mos = new MemoryCacheImageOutputStream( new FileOutputStream( destFilename ) );
            constrain( fis, mos, boxSize );
        }
        catch( Exception e )
        {
            e.printStackTrace();
        }
    }

    public static byte[] constrain( String srcFilename, int boxSize )
    {
        try
        {
            FileInputStream fis = new FileInputStream( srcFilename );
            ByteArrayOutputStream baos = new ByteArrayOutputStream();
            MemoryCacheImageOutputStream mos = new MemoryCacheImageOutputStream( baos );
            constrain( fis, mos, boxSize );
            return baos.toByteArray();
            //ByteArrayInputSteam bais = new ByteArrayInputStream( baos.toByteArray() );
            //return bais;
        }
        catch( Exception e )
        {
            e.printStackTrace();
        }
        return new byte[]{};
    }
    
    public static byte[] constrain( InputStream is, int boxSize )
    {
        try
        {
            ByteArrayOutputStream baos = new ByteArrayOutputStream();
            MemoryCacheImageOutputStream mos = new MemoryCacheImageOutputStream( baos );
            constrain( is, mos, boxSize );
            return baos.toByteArray();
        }
        catch( Exception e )
        {
            e.printStackTrace();
        }
        return new byte[]{};
    }

    public static void constrain( String srcFilename, OutputStream os, int boxSize )
    {
        try
        {
            FileInputStream fis = new FileInputStream( srcFilename );
            MemoryCacheImageOutputStream mos = new MemoryCacheImageOutputStream( os );
            constrain( fis, mos, boxSize );
        }
        catch( Exception e )
        {
            e.printStackTrace();
        }
    }

    public static void constrain( InputStream is, ImageOutputStream os, int boxSize )
    {
        try
        {
            // Read the source file
            BufferedImage input = ImageIO.read( is );

            // Get the original size of the image
            int srcHeight = input.getHeight();
            int srcWidth = input.getWidth();

            // Constrain the thumbnail to a predefined box size
            int height = boxSize;
            int width = boxSize;
            if( srcHeight > srcWidth )
            {
                width = ( int )( ( ( float )height / ( float )srcHeight ) * ( float )srcWidth );
            }
            else if( srcWidth > srcHeight )
            {
                height = ( int )( ( ( float )width / ( float )srcWidth ) * ( float )srcHeight );
            }

            // Create a new thumbnail BufferedImage
            BufferedImage thumb = new BufferedImage( width, height, BufferedImage.TYPE_USHORT_565_RGB );
            Graphics g = thumb.getGraphics();
            g.drawImage( input, 0, 0, width, height, null );

            // Get Writer and set compression
            Iterator iter = ImageIO.getImageWritersByFormatName( "JPG" );
            if( iter.hasNext() ) 
            {
                ImageWriter writer = (ImageWriter)iter.next();
                ImageWriteParam iwp = writer.getDefaultWriteParam();
                iwp.setCompressionMode( ImageWriteParam.MODE_EXPLICIT );
                //iwp.setCompressionQuality( 0.75f );
                iwp.setCompressionQuality( 0.95f );
                writer.setOutput( os );
                IIOImage image = new IIOImage(thumb, null, null);
                writer.write(null, image, iwp);
            }
        }
        catch( Exception e )
        {
            e.printStackTrace();
        }
    }
    
    public static void main( String[] args )
    {
        if( args.length < 1 )
        {
            System.out.println( "Usage: ImageUtils <command> <options...>" );
            System.exit( 0 );
        }

        String command = args[ 0 ];
        
        if( command.equalsIgnoreCase( "constrain" ) )
        {
            if( args.length < 2 ) 
            {
                System.out.println( "Usage: ImageUtils constrain {file|folder} <src> <dest> <size>" );
                System.exit( 0 );
            }

            String mode = args[ 1 ];
            String src = args[ 2 ];
            String dest = args[ 3 ];
            int size = Integer.parseInt( args[ 4 ] );
            if( mode.equalsIgnoreCase( "file" ) )
            {
                ImageUtils.constrain( src, dest, size );
            }
            else
            {
                File sourceDir = new File( src );
                File destDir = new File( dest );
                if( sourceDir.exists() && sourceDir.isDirectory() )
                {
                    String[] srcFns = sourceDir.list();
                }
            }
        }

        String src = args[ 0 ];
        String dest = args[ 1 ];
        constrain( src, dest, 128 );
    }
    
}
